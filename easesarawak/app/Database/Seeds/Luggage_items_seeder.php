<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Luggage_items_seeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'order_id'        => 1,
                'size'            => 'Medium',
                'insured'         => 1,
                'special_request' => null,
            ],
            [
                'order_id'        => 1,
                'size'            => 'Small',
                'insured'         => 0,
                'special_request' => null,
            ],
            [
                'order_id'        => 2,
                'size'            => 'Large',
                'insured'         => 1,
                'special_request' => 'This contains electronics - handle carefully',
            ],
            [
                'order_id'        => 2,
                'size'            => 'Oversized',
                'insured'         => 1,
                'special_request' => 'Fragile - musical instrument inside',
            ],
            [
                'order_id'        => 3,
                'size'            => 'Large',
                'insured'         => 0,
                'special_request' => 'Winter clothing',
            ],
            [
                'order_id'        => 4,
                'size'            => 'Medium',
                'insured'         => 1,
                'special_request' => null,
            ],
        ];

        $this->db->table('LuggageItems')->insertBatch($data);
    }
}
