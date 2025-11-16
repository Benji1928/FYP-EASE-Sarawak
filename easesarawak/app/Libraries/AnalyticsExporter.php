<?php

namespace App\Libraries;

class AnalyticsExporter
{
    public function build(string $title, array $columns, array $rows, string $format): array
    {
        switch ($format) {
            case 'csv':
                return [
                    'mime' => 'text/csv',
                    'content' => $this->buildCsv($columns, $rows),
                ];
            case 'json':
                return [
                    'mime' => 'application/json',
                    'content' => $this->buildJson($title, $columns, $rows),
                ];
            case 'pdf':
                return [
                    'mime' => 'application/pdf',
                    'content' => $this->buildPdf($title, $columns, $rows),
                ];
        }

        throw new \InvalidArgumentException('Unsupported export format: ' . $format);
    }

    private function buildCsv(array $columns, array $rows): string
    {
        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, array_values($columns));

        foreach ($rows as $row) {
            $line = [];
            foreach ($columns as $field => $label) {
                $line[] = $row[$field] ?? '';
            }

            fputcsv($handle, $line);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return $csv ?: '';
    }

    private function buildJson(string $title, array $columns, array $rows): string
    {
        $payload = [
            'title' => $title,
            'generated_at' => date('c'),
            'columns' => $columns,
            'rows' => $rows,
            'count' => count($rows),
        ];

        return json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: '{}';
    }

    private function buildPdf(string $title, array $columns, array $rows): string
    {
        $renderer = new SimplePdfRenderer();

        return $renderer->render($title, $columns, $rows);
    }
}

class SimplePdfRenderer
{
    private int $rowsPerPage = 32;

    public function render(string $title, array $columns, array $rows): string
    {
        $rows = array_map(function ($row) {
            return is_array($row) ? $row : (array) $row;
        }, $rows);

        $pages = array_chunk($rows, $this->rowsPerPage);
        if (empty($pages)) {
            $pages = [[]];
        }

        $pageCount = count($pages);
        $streams = [];

        foreach ($pages as $index => $pageRows) {
            $streams[] = $this->buildStream(
                $title,
                $columns,
                $pageRows,
                $index + 1,
                $pageCount
            );
        }

        return $this->assemblePdf($streams);
    }

    private function buildStream(string $title, array $columns, array $rows, int $pageNumber, int $totalPages): string
    {
        $lines = [];
        $lines[] = $this->textLine(72, 760, $title, 16);
        $lines[] = $this->textLine(
            72,
            742,
            sprintf('Generated %s - Page %d of %d', date('Y-m-d H:i'), $pageNumber, $totalPages),
            9
        );

        $y = 720;
        $header = implode(' | ', array_map([$this, 'shorten'], array_values($columns), array_fill(0, count($columns), 28)));
        $lines[] = $this->textLine(72, $y, $header, 11);
        $y -= 16;

        if (empty($rows)) {
            $lines[] = $this->textLine(72, $y, 'No records found for the selected filters.', 10);
        } else {
            foreach ($rows as $row) {
                $lineParts = [];
                foreach ($columns as $field => $label) {
                    $value = $row[$field] ?? '';
                    $lineParts[] = $this->shorten($this->formatValue($value));
                }

                $lines[] = $this->textLine(72, $y, implode(' | ', $lineParts), 10);
                $y -= 14;
            }
        }

        return implode("\n", $lines);
    }

    private function assemblePdf(array $streams): string
    {
        $objects = [];
        $objects[1] = '<< /Type /Catalog /Pages 2 0 R >>';
        $objects[3] = '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>';

        $kids = [];
        $nextId = 4;
        foreach ($streams as $stream) {
            $pageId = $nextId++;
            $contentId = $nextId++;
            $kids[] = sprintf('%d 0 R', $pageId);

            $objects[$pageId] = sprintf(
                '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents %d 0 R /Resources << /Font << /F1 3 0 R >> >> >>',
                $contentId
            );
            $objects[$contentId] = sprintf("<< /Length %d >>\nstream\n%s\nendstream", strlen($stream), $stream);
        }

        if (empty($kids)) {
            $kids[] = '4 0 R';
            $objects[4] = '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 5 0 R /Resources << /Font << /F1 3 0 R >> >> >>';
            $objects[5] = "<< /Length 15 >>\nstream\nBT ET\nendstream";
        }

        $objects[2] = sprintf('<< /Type /Pages /Count %d /Kids [%s] >>', count($kids), implode(' ', $kids));

        ksort($objects);
        $pdf = "%PDF-1.4\n";
        $offsets = [];
        $position = strlen($pdf);

        foreach ($objects as $id => $body) {
            $object = sprintf("%d 0 obj\n%s\nendobj\n", $id, $body);
            $offsets[$id] = $position;
            $pdf .= $object;
            $position = strlen($pdf);
        }

        $xrefPosition = strlen($pdf);
        $lastId = empty($objects) ? 0 : max(array_keys($objects));
        $pdf .= sprintf("xref\n0 %d\n", $lastId + 1);
        $pdf .= "0000000000 65535 f \n";
        for ($i = 1; $i <= $lastId; $i++) {
            $offset = $offsets[$i] ?? 0;
            $pdf .= sprintf("%010d 00000 n \n", $offset);
        }
        $pdf .= "trailer\n";
        $pdf .= sprintf("<< /Size %d /Root 1 0 R >>\n", $lastId + 1);
        $pdf .= "startxref\n";
        $pdf .= $xrefPosition . "\n%%EOF";

        return $pdf;
    }

    private function textLine(int $x, int $y, string $text, int $fontSize): string
    {
        return sprintf(
            "BT /F1 %d Tf %d %d Td (%s) Tj ET",
            $fontSize,
            $x,
            $y,
            $this->escapeText($text)
        );
    }

    private function formatValue($value): string
    {
        if ($value instanceof \DateTimeInterface) {
            return $value->format('Y-m-d H:i');
        }

        if (is_bool($value)) {
            return $value ? 'Yes' : 'No';
        }

        if (is_numeric($value)) {
            return (string) $value;
        }

        if ($value === null) {
            return '';
        }

        return trim((string) $value);
    }

    private function escapeText(string $text): string
    {
        return strtr($text, [
            '\\' => '\\\\',
            '(' => '\\(',
            ')' => '\\)',
            "\r" => ' ',
            "\n" => ' ',
        ]);
    }

    private function shorten(string $text, int $limit = 64): string
    {
        $text = trim($text);
        if (strlen($text) <= $limit) {
            return $text;
        }

        return substr($text, 0, $limit - 3) . '...';
    }
}
