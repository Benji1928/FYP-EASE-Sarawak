<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Tourist_arrivals_data_seeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'period_start'           => '2024-10-01',
                'period_end'             => '2024-10-31',
                'location'               => 'Kuching',
                'total_arrivals'         => 45000,
                'international_arrivals' => 15000,
                'domestic_arrivals'      => 30000,
                'data_source'            => 'DOSM_API',
                'created_date'           => date('Y-m-d H:i:s'),
            ],
            [
                'period_start'           => '2024-11-01',
                'period_end'             => '2024-11-30',
                'location'               => 'Kuching',
                'total_arrivals'         => 52000,
                'international_arrivals' => 18000,
                'domestic_arrivals'      => 34000,
                'data_source'            => 'DOSM_API',
                'created_date'           => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('Tourist_Arrivals_Data')->insertBatch($data);
    }
}
