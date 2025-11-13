<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Users_seeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'first_name'          => 'John',
                'last_name'           => 'Doe',
                'email'               => 'john.doe@example.com',
                'phone'               => '+60168888888',
                'social'              => 'MyKad',
                'social_num'          => '123456789012',
                'nationality'         => 'USA',
                'customer_type'       => 'tourist',
                'customer_segment'    => 'short_stay',
                'source_of_booking'   => 'online',
                'created_date'        => date('Y-m-d H:i:s'),
            ],
            [
                'first_name'          => 'Jane',
                'last_name'           => 'Smith',
                'email'               => 'jane.smith@example.com',
                'phone'               => '+60169999999',
                'social'              => 'Passport',
                'social_num'          => 'A12345678',
                'nationality'         => 'UK',
                'customer_type'       => 'tourist',
                'customer_segment'    => 'layover',
                'source_of_booking'   => 'partner',
                'created_date'        => date('Y-m-d H:i:s'),
            ],
            [
                'first_name'          => 'Ahmad',
                'last_name'           => 'Hassan',
                'email'               => 'ahmad.hassan@example.com',
                'phone'               => '+60167777777',
                'social'              => 'MyKad',
                'social_num'          => '123456780123',
                'nationality'         => 'Malaysia',
                'customer_type'       => 'local',
                'customer_segment'    => null,
                'source_of_booking'   => 'walk-in',
                'created_date'        => date('Y-m-d H:i:s'),
            ],
            [
                'first_name'          => 'Maria',
                'last_name'           => 'Garcia',
                'email'               => 'maria.garcia@example.com',
                'phone'               => '+60165555555',
                'social'              => 'Passport',
                'social_num'          => 'B98765432',
                'nationality'         => 'Spain',
                'customer_type'       => 'business_traveller',
                'customer_segment'    => 'short_stay',
                'source_of_booking'   => 'online',
                'created_date'        => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('Users')->insertBatch($data);
    }
}
