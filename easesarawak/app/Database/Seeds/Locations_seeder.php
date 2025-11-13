<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Locations_seeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'            => 'Kuching International Airport',
                'category'        => 'Airport',
                'address'         => 'Kuching International Airport, Sarawak',
                'total_capacity'  => 200,
                'created_date'    => date('Y-m-d H:i:s'),
            ],
            [
                'name'            => 'Hilton Kuching',
                'category'        => 'Hotel',
                'address'         => 'Jalan Tunku Abdul Rahman, Kuching',
                'total_capacity'  => 100,
                'created_date'    => date('Y-m-d H:i:s'),
            ],
            [
                'name'            => 'Riverside Shopping Mall',
                'category'        => 'Shopping Mall',
                'address'         => 'Jalan Tunku Abdul Rahman, Kuching',
                'total_capacity'  => 50,
                'created_date'    => date('Y-m-d H:i:s'),
            ],
            [
                'name'            => 'Sarawak Cultural Village',
                'category'        => 'Other',
                'address'         => 'Pantai Damai, Santubong',
                'total_capacity'  => 30,
                'created_date'    => date('Y-m-d H:i:s'),
            ],
            [
                'name'            => 'EASE Main Hub',
                'category'        => 'Hub',
                'address'         => 'Kuching City Center, Sarawak',
                'total_capacity'  => 500,
                'created_date'    => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('Locations')->insertBatch($data);
    }
}
