<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Reviews_seeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'order_id'      => 3,
                'rating'        => 5,
                'comment'       => 'Excellent service! Delivery was on time and items were safe.',
                'source'        => 'Website',
                'external_link' => null,
                'created_date'  => date('Y-m-d H:i:s'),
            ],
            [
                'order_id'      => 4,
                'rating'        => 4,
                'comment'       => 'Good service, could improve on communication.',
                'source'        => 'Google',
                'external_link' => 'https://google.com/review/example1',
                'created_date'  => date('Y-m-d H:i:s'),
            ],
            [
                'order_id'      => null,
                'rating'        => 5,
                'comment'       => 'EASE Sarawak is the best luggage service in Sarawak!',
                'source'        => 'Others',
                'external_link' => null,
                'created_date'  => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('Reviews')->insertBatch($data);
    }
}
