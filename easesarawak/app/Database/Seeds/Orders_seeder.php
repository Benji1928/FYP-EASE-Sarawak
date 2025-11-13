<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Orders_seeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id'              => 1,
                'special'              => 0,
                'special_note'         => null,
                'service_type'         => 'Delivery',
                'order_details_json'   => json_encode(['item_count' => 2, 'weight' => '5kg']),
                'dropoff_time'         => '2025-11-20 14:00:00',
                'pickup_time'          => '2025-11-20 10:00:00',
                'pickup_location_id'   => 1,
                'dropoff_location_id'  => 2,
                'order_status'         => 'Pending',
                'promo_code'           => 'PROMO2025',
                'is_cancelled'         => 0,
                'created_date'         => date('Y-m-d H:i:s'),
                'modified_by'          => null,
                'payment_id'           => 1,
                'partner_id'           => 1,
            ],
            [
                'user_id'              => 2,
                'special'              => 1,
                'special_note'         => 'Handle with care - Fragile items',
                'service_type'         => 'Storage',
                'order_details_json'   => json_encode(['item_count' => 5, 'weight' => '15kg']),
                'dropoff_time'         => '2025-11-25 16:30:00',
                'pickup_time'          => '2025-11-20 11:00:00',
                'pickup_location_id'   => 3,
                'dropoff_location_id'  => 4,
                'order_status'         => 'Confirmed',
                'promo_code'           => null,
                'is_cancelled'         => 0,
                'created_date'         => date('Y-m-d H:i:s'),
                'modified_by'          => null,
                'payment_id'           => 2,
                'partner_id'           => 2,
            ],
            [
                'user_id'              => 3,
                'special'              => 0,
                'special_note'         => null,
                'service_type'         => 'Delivery',
                'order_details_json'   => json_encode(['item_count' => 1, 'weight' => '10kg']),
                'dropoff_time'         => '2025-11-22 12:00:00',
                'pickup_time'          => '2025-11-22 09:00:00',
                'pickup_location_id'   => 2,
                'dropoff_location_id'  => 5,
                'order_status'         => 'Out-for-Delivery',
                'promo_code'           => 'WELCOME50',
                'is_cancelled'         => 0,
                'created_date'         => date('Y-m-d H:i:s'),
                'modified_by'          => null,
                'payment_id'           => 3,
                'partner_id'           => 5,
            ],
            [
                'user_id'              => 4,
                'special'              => 1,
                'special_note'         => 'Leave at reception desk',
                'service_type'         => 'Delivery',
                'order_details_json'   => json_encode(['item_count' => 3, 'weight' => '8kg']),
                'dropoff_time'         => '2025-11-23 15:00:00',
                'pickup_time'          => '2025-11-23 10:00:00',
                'pickup_location_id'   => 5,
                'dropoff_location_id'  => 1,
                'order_status'         => 'Completed',
                'promo_code'           => 'NEWUSER',
                'is_cancelled'         => 0,
                'created_date'         => date('Y-m-d H:i:s'),
                'modified_by'          => null,
                'payment_id'           => 4,
                'partner_id'           => 1,
            ],
        ];

        $this->db->table('Orders')->insertBatch($data);
    }
}
