<?php

namespace App\Controllers;

use App\Libraries\AnalyticsExporter;
use CodeIgniter\Exceptions\PageNotFoundException;

class AdminAnalytics extends BaseAdminController
{
    protected $db;
    protected AnalyticsExporter $exporter;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->exporter = new AnalyticsExporter();
    }

    // Revenue analytics
    public function revenue()
    {
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-d');

        $data = $this->fetchRevenueData($startDate, $endDate);
        $data['title'] = 'Revenue Analytics';

        return view('admin/analytics/revenue', $data);
    }

    // Customer analytics
    public function customers()
    {
        $data = $this->fetchCustomerData();
        $data['title'] = 'Customer Analytics';

        return view('admin/analytics/customers', $data);
    }

    // Operations analytics
    public function operations()
    {
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-d');

        $data = $this->fetchOperationsData($startDate, $endDate);
        $data['title'] = 'Operations Analytics';

        return view('admin/analytics/operations', $data);
    }

    // External data dashboard
    public function externalData()
    {
        $data = $this->fetchExternalData();
        $data['title'] = 'External Data Dashboard';

        return view('admin/analytics/external_data', $data);
    }

    /**
     * Export analytics datasets as CSV, JSON, or PDF.
     */
    public function export(string $type = 'revenue')
    {
        $format = strtolower($this->request->getGet('format') ?? 'csv');
        $section = strtolower($this->request->getGet('section') ?? 'default');

        if (! in_array($format, ['csv', 'json', 'pdf'], true)) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'status' => 'error',
                    'message' => 'Unsupported export format. Allowed formats: csv, json, pdf',
                ]);
        }

        [$dataset, $filters] = $this->resolveDatasetForExport($type);
        $payload = $this->resolveExportPayload($type, $section, $dataset);

        if ($payload === null) {
            throw PageNotFoundException::forPageNotFound('Analytics export section not found.');
        }

        $export = $this->exporter->build($payload['title'], $payload['columns'], $payload['rows'], $format);
        $filename = $this->buildFilename($type, $section, $format, $filters);

        return $this->response
            ->setHeader('Content-Type', $export['mime'])
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($export['content']);
    }

    private function resolveDatasetForExport(string $type): array
    {
        switch ($type) {
            case 'revenue':
                $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
                $endDate = $this->request->getGet('end_date') ?? date('Y-m-d');
                return [$this->fetchRevenueData($startDate, $endDate, true), compact('startDate', 'endDate')];
            case 'customers':
                return [$this->fetchCustomerData(true), []];
            case 'operations':
                $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
                $endDate = $this->request->getGet('end_date') ?? date('Y-m-d');
                return [$this->fetchOperationsData($startDate, $endDate, true), compact('startDate', 'endDate')];
            default:
                throw PageNotFoundException::forPageNotFound('Analytics export type not found.');
        }
    }

    private function resolveExportPayload(string $type, string $section, array $dataset): ?array
    {
        switch ($type) {
            case 'revenue':
                return $this->prepareRevenuePayload($section, $dataset);
            case 'customers':
                return $this->prepareCustomerPayload($section, $dataset);
            case 'operations':
                return $this->prepareOperationsPayload($section, $dataset);
            default:
                return null;
        }
    }

    private function prepareRevenuePayload(string $section, array $dataset): array
    {
        $section = in_array($section, ['channel', 'service'], true) ? $section : 'daily';
        $titleBase = 'Revenue Analytics';
        $range = isset($dataset['start_date'], $dataset['end_date'])
            ? sprintf(' (%s to %s)', $dataset['start_date'], $dataset['end_date'])
            : '';

        if ($section === 'channel') {
            $columns = [
                'revenue_channel' => 'Channel',
                'transaction_count' => 'Transactions',
                'total_revenue' => 'Net Revenue',
            ];

            return [
                'title' => $titleBase . ' - By Channel' . $range,
                'columns' => $columns,
                'rows' => $this->normalizeRows($dataset['revenue_by_channel'] ?? [], $columns),
            ];
        }

        if ($section === 'service') {
            $columns = [
                'service_type' => 'Service',
                'transaction_count' => 'Transactions',
                'total_revenue' => 'Net Revenue',
            ];

            return [
                'title' => $titleBase . ' - By Service' . $range,
                'columns' => $columns,
                'rows' => $this->normalizeRows($dataset['revenue_by_service'] ?? [], $columns),
            ];
        }

        $columns = [
            'transaction_date' => 'Date',
            'service_revenue' => 'Service Revenue',
            'delivery_revenue' => 'Delivery Revenue',
            'insurance_revenue' => 'Insurance Revenue',
            'partner_commission' => 'Partner Commission',
            'net_revenue' => 'Net Revenue',
        ];

        return [
            'title' => $titleBase . ' - Daily Totals' . $range,
            'columns' => $columns,
            'rows' => $this->normalizeRows($dataset['daily_revenue'] ?? [], $columns),
        ];
    }

    private function prepareCustomerPayload(string $section, array $dataset): array
    {
        $section = in_array($section, ['segments', 'acquisition'], true) ? $section : 'lifetime';
        $titleBase = 'Customer Analytics';

        if ($section === 'segments') {
            $columns = [
                'customer_type' => 'Customer Type',
                'count' => 'Customers',
                'avg_lifetime_value' => 'Avg Lifetime Value',
            ];

            return [
                'title' => $titleBase . ' - Segmentation',
                'columns' => $columns,
                'rows' => $this->normalizeRows($dataset['customer_by_type'] ?? [], $columns),
            ];
        }

        if ($section === 'acquisition') {
            $columns = [
                'month' => 'Month',
                'source_of_booking' => 'Source',
                'new_customers' => 'New Customers',
            ];

            return [
                'title' => $titleBase . ' - Acquisition Trend',
                'columns' => $columns,
                'rows' => $this->normalizeRows($dataset['acquisition_trend'] ?? [], $columns),
            ];
        }

        $columns = [
            'rank' => '#',
            'customer_name' => 'Customer',
            'email' => 'Email',
            'customer_type' => 'Type',
            'total_orders' => 'Total Orders',
            'total_spent' => 'Total Spent',
            'avg_order_value' => 'Avg Order Value',
            'avg_rating' => 'Avg Rating',
            'last_order_date' => 'Last Order',
        ];

        $topCustomers = array_values($dataset['top_customers'] ?? []);
        $rows = [];
        foreach ($topCustomers as $index => $row) {
            if (! is_array($row)) {
                $row = (array) $row;
            }

            $row['rank'] = $index + 1;
            $row['customer_name'] = $row['customer_name']
                ?? ($row['full_name'] ?? ($row['first_name'] ?? ($row['last_name'] ?? '')));
            $rows[] = $row;
        }

        return [
            'title' => $titleBase . ' - Top Customers',
            'columns' => $columns,
            'rows' => $this->normalizeRows($rows, $columns),
        ];
    }

    private function prepareOperationsPayload(string $section, array $dataset): array
    {
        $section = in_array($section, ['delivery', 'storage'], true) ? $section : 'daily';
        $titleBase = 'Operations Analytics';
        $range = isset($dataset['start_date'], $dataset['end_date'])
            ? sprintf(' (%s to %s)', $dataset['start_date'], $dataset['end_date'])
            : '';

        if ($section === 'delivery') {
            $columns = [
                'date' => 'Date',
                'total_deliveries' => 'Deliveries',
                'on_time_deliveries' => 'On-Time Deliveries',
                'avg_duration' => 'Avg Duration (mins)',
                'avg_delay' => 'Avg Delay (mins)',
            ];

            return [
                'title' => $titleBase . ' - Delivery Performance' . $range,
                'columns' => $columns,
                'rows' => $this->normalizeRows($dataset['delivery_performance'] ?? [], $columns),
            ];
        }

        if ($section === 'storage') {
            $columns = [
                'name' => 'Location',
                'category' => 'Category',
                'total_capacity' => 'Capacity',
                'current_occupancy' => 'Current',
                'occupancy_rate' => 'Occupancy %',
            ];

            return [
                'title' => $titleBase . ' - Storage Occupancy',
                'columns' => $columns,
                'rows' => $this->normalizeRows($dataset['storage_occupancy'] ?? [], $columns),
            ];
        }

        $rows = $dataset['daily_ops'] ?? [];
        $columns = $this->inferColumns($rows, [
            'operation_date' => 'Date',
            'orders_processed' => 'Orders Processed',
            'delayed_orders' => 'Delayed Orders',
            'incidents_reported' => 'Incidents',
            'avg_storage_hours' => 'Avg Storage (hrs)',
        ]);

        return [
            'title' => $titleBase . ' - Daily Summary' . $range,
            'columns' => $columns,
            'rows' => $this->normalizeRows($rows, $columns),
        ];
    }

    private function fetchRevenueData(string $startDate, string $endDate, bool $asArray = false): array
    {
        $dailyRevenueQuery = $this->db->query("
            SELECT
                transaction_date,
                SUM(service_revenue) as service_revenue,
                SUM(delivery_revenue) as delivery_revenue,
                SUM(insurance_revenue) as insurance_revenue,
                SUM(partner_commission) as partner_commission,
                SUM(net_revenue) as net_revenue
            FROM Revenue_Records
            WHERE transaction_date BETWEEN ? AND ?
            GROUP BY transaction_date
            ORDER BY transaction_date ASC
        ", [$startDate, $endDate]);

        $revenueByChannelQuery = $this->db->query("
            SELECT
                revenue_channel,
                SUM(net_revenue) as total_revenue,
                COUNT(*) as transaction_count
            FROM Revenue_Records
            WHERE transaction_date BETWEEN ? AND ?
            GROUP BY revenue_channel
        ", [$startDate, $endDate]);

        $revenueByServiceQuery = $this->db->query("
            SELECT
                service_type,
                SUM(net_revenue) as total_revenue,
                COUNT(*) as transaction_count
            FROM Revenue_Records
            WHERE transaction_date BETWEEN ? AND ?
            GROUP BY service_type
        ", [$startDate, $endDate]);

        return [
            'title' => 'Revenue Analytics',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'daily_revenue' => $asArray ? $dailyRevenueQuery->getResultArray() : $dailyRevenueQuery->getResult(),
            'revenue_by_channel' => $asArray ? $revenueByChannelQuery->getResultArray() : $revenueByChannelQuery->getResult(),
            'revenue_by_service' => $asArray ? $revenueByServiceQuery->getResultArray() : $revenueByServiceQuery->getResult(),
        ];
    }

    private function fetchCustomerData(bool $asArray = false): array
    {
        $topCustomersQuery = $this->db->query("
            SELECT *
            FROM customer_lifetime_value
            ORDER BY total_spent DESC
            LIMIT 50
        ");

        $customerByTypeQuery = $this->db->query("
            SELECT
                customer_type,
                COUNT(*) as count,
                AVG(lifetime_value) as avg_lifetime_value
            FROM Users
            GROUP BY customer_type
        ");

        $acquisitionTrendQuery = $this->db->query("
            SELECT
                DATE_FORMAT(created_date, '%Y-%m') as month,
                source_of_booking,
                COUNT(*) as new_customers
            FROM Users
            GROUP BY month, source_of_booking
            ORDER BY month DESC
            LIMIT 12
        ");

        return [
            'title' => 'Customer Analytics',
            'top_customers' => $asArray ? $topCustomersQuery->getResultArray() : $topCustomersQuery->getResult(),
            'customer_by_type' => $asArray ? $customerByTypeQuery->getResultArray() : $customerByTypeQuery->getResult(),
            'acquisition_trend' => $asArray ? $acquisitionTrendQuery->getResultArray() : $acquisitionTrendQuery->getResult(),
        ];
    }

    private function fetchOperationsData(string $startDate, string $endDate, bool $asArray = false): array
    {
        $dailyOpsQuery = $this->db->query("
            SELECT *
            FROM daily_operations_summary
            WHERE operation_date BETWEEN ? AND ?
            ORDER BY operation_date DESC
        ", [$startDate, $endDate]);

        $deliveryPerformanceQuery = $this->db->query("
            SELECT
                DATE(d.created_date) as date,
                COUNT(*) as total_deliveries,
                SUM(CASE WHEN d.on_time = 1 THEN 1 ELSE 0 END) as on_time_deliveries,
                AVG(d.actual_duration_minutes) as avg_duration,
                AVG(d.delay_minutes) as avg_delay
            FROM Delivery d
            WHERE DATE(d.created_date) BETWEEN ? AND ?
            GROUP BY DATE(d.created_date)
            ORDER BY date DESC
        ", [$startDate, $endDate]);

        $storageOccupancyQuery = $this->db->query("
            SELECT
                name,
                category,
                total_capacity,
                current_occupancy,
                ROUND((current_occupancy / total_capacity) * 100, 2) as occupancy_rate
            FROM Locations
            WHERE category IN ('Hub', 'Airport', 'Hotel')
              AND total_capacity > 0
            ORDER BY occupancy_rate DESC
        ");

        return [
            'title' => 'Operations Analytics',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'daily_ops' => $asArray ? $dailyOpsQuery->getResultArray() : $dailyOpsQuery->getResult(),
            'delivery_performance' => $asArray ? $deliveryPerformanceQuery->getResultArray() : $deliveryPerformanceQuery->getResult(),
            'storage_occupancy' => $asArray ? $storageOccupancyQuery->getResultArray() : $storageOccupancyQuery->getResult(),
        ];
    }

    private function fetchExternalData(bool $asArray = false): array
    {
        $touristArrivalsBuilder = $this->db->table('Tourist_Arrivals_Data')
            ->orderBy('period_start', 'DESC')
            ->limit(12)
            ->get();

        $upcomingEventsBuilder = $this->db->table('Local_Events')
            ->where('event_start_date >=', date('Y-m-d'))
            ->orderBy('event_start_date', 'ASC')
            ->limit(10)
            ->get();

        $hotelOccupancyBuilder = $this->db->table('Hotel_Occupancy_Stats')
            ->orderBy('period_date', 'DESC')
            ->limit(30)
            ->get();

        return [
            'title' => 'External Data Dashboard',
            'tourist_arrivals' => $asArray ? $touristArrivalsBuilder->getResultArray() : $touristArrivalsBuilder->getResult(),
            'upcoming_events' => $asArray ? $upcomingEventsBuilder->getResultArray() : $upcomingEventsBuilder->getResult(),
            'hotel_occupancy' => $asArray ? $hotelOccupancyBuilder->getResultArray() : $hotelOccupancyBuilder->getResult(),
        ];
    }

    private function normalizeRows(array $rows, array $columns): array
    {
        return array_map(function ($row) use ($columns) {
            if (! is_array($row)) {
                $row = (array) $row;
            }

            $normalized = [];
            foreach ($columns as $field => $label) {
                $value = $row[$field] ?? '';
                if ($value instanceof \DateTimeInterface) {
                    $value = $value->format('Y-m-d');
                } elseif (is_bool($value)) {
                    $value = $value ? 'Yes' : 'No';
                }

                $normalized[$field] = $value;
            }

            return $normalized;
        }, $rows);
    }

    private function inferColumns(array $rows, array $preferred): array
    {
        if (! empty($rows)) {
            $first = $rows[0];
            $keys = array_keys($first);
            $columns = [];
            foreach ($keys as $key) {
                $columns[$key] = $preferred[$key] ?? ucwords(str_replace('_', ' ', $key));
            }

            return $columns;
        }

        return $preferred;
    }

    private function buildFilename(string $type, string $section, string $format, array $filters = []): string
    {
        $parts = ['analytics', $type];
        if ($section && $section !== 'default') {
            $parts[] = $section;
        }

        if (isset($filters['startDate'], $filters['endDate'])) {
            $parts[] = $filters['startDate'] . '_to_' . $filters['endDate'];
        }

        $parts[] = date('Ymd_His');

        return implode('-', array_filter($parts)) . '.' . $format;
    }
}
