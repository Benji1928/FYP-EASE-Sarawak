<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Delivery_seeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'order_id'       => 1,
                'driver_id'      => 3, // Driver Ahmad
                'status'         => 'Delivered',
                'completed_time' => '2025-11-20 14:30:00',
            ],
            [
                'order_id'       => 2,
                'driver_id'      => 3, // Driver Ahmad
                'status'         => 'Pending',
                'completed_time' => null,
            ],
            [
                'order_id'       => 3,
                'driver_id'      => 3, // Driver Ahmad
                'status'         => 'On Route',
                'completed_time' => null,
            ],
            [
                'order_id'       => 4,
                'driver_id'      => 3, // Driver Ahmad
                'status'         => 'Delivered',
                'completed_time' => '2025-11-23 15:45:00',
            ],
        ];

        $this->db->table('Delivery')->insertBatch($data);
    }
}
