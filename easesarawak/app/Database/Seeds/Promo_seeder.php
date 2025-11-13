<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Promo_seeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'promo_code'      => 'PROMO2025',
                'discount_type'   => 'Percent',
                'discount_value'  => 10.00,
                'start_date'      => '2025-01-01 00:00:00',
                'end_date'        => '2025-12-31 23:59:59',
                'usage_limit'     => 100,
                'created_by'      => 1,
                'created_date'    => date('Y-m-d H:i:s'),
            ],
            [
                'promo_code'      => 'WELCOME50',
                'discount_type'   => 'Flat',
                'discount_value'  => 50.00,
                'start_date'      => '2025-01-01 00:00:00',
                'end_date'        => '2025-06-30 23:59:59',
                'usage_limit'     => 50,
                'created_by'      => 1,
                'created_date'    => date('Y-m-d H:i:s'),
            ],
            [
                'promo_code'      => 'NEWUSER',
                'discount_type'   => 'Percent',
                'discount_value'  => 15.00,
                'start_date'      => '2025-11-01 00:00:00',
                'end_date'        => '2025-11-30 23:59:59',
                'usage_limit'     => null,
                'created_by'      => 2,
                'created_date'    => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('Promo')->insertBatch($data);
    }
}
