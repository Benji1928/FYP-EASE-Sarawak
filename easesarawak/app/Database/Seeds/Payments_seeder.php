<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Payments_seeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'order_id'        => 1,
                'amount'          => 150.00,
                'status'          => 'Paid',
                'method'          => 'Card',
                'transaction_ref' => 'TXN20251120001',
                'paid_time'       => '2025-11-20 10:15:00',
            ],
            [
                'order_id'        => 2,
                'amount'          => 250.00,
                'status'          => 'Pending',
                'method'          => 'Online Transaction',
                'transaction_ref' => 'TXN20251121001',
                'paid_time'       => null,
            ],
            [
                'order_id'        => 3,
                'amount'          => 200.00,
                'status'          => 'Paid',
                'method'          => 'Card',
                'transaction_ref' => 'TXN20251122001',
                'paid_time'       => '2025-11-22 09:30:00',
            ],
            [
                'order_id'        => 4,
                'amount'          => 180.00,
                'status'          => 'Paid',
                'method'          => 'Card',
                'transaction_ref' => 'TXN20251123001',
                'paid_time'       => '2025-11-23 10:45:00',
            ],
        ];

        $this->db->table('Payments')->insertBatch($data);
    }
}
