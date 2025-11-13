<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Local_events_seeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'event_name'         => 'Rainforest World Music Festival',
                'event_type'         => 'festival',
                'event_start_date'   => '2025-07-19',
                'event_end_date'     => '2025-07-21',
                'expected_attendance' => 25000,
                'impact_level'       => 'high',
                'created_date'       => date('Y-m-d H:i:s'),
            ],
            [
                'event_name'         => 'Kuching Food Festival',
                'event_type'         => 'festival',
                'event_start_date'   => '2025-08-15',
                'event_end_date'     => '2025-08-17',
                'expected_attendance' => 15000,
                'impact_level'       => 'medium',
                'created_date'       => date('Y-m-d H:i:s'),
            ],
            [
                'event_name'         => 'Sarawak Regatta',
                'event_type'         => 'sports',
                'event_start_date'   => '2025-09-20',
                'event_end_date'     => '2025-09-22',
                'expected_attendance' => 10000,
                'impact_level'       => 'medium',
                'created_date'       => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('Local_Events')->insertBatch($data);
    }
}
