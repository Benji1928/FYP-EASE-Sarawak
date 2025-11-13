<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Partners_seeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'            => 'Sarawak Hotels Group',
                'commission_rate' => 5.50,
                'type'            => 'Hotel',
                'contact_email'   => 'partners@sarawakhotels.com',
                'is_active'       => true,
                'created_date'    => date('Y-m-d H:i:s'),
            ],
            [
                'name'            => 'Local Tour Operators',
                'commission_rate' => 8.00,
                'type'            => 'TourAgency',
                'contact_email'   => 'info@localtours.com',
                'is_active'       => true,
                'created_date'    => date('Y-m-d H:i:s'),
            ],
            [
                'name'            => 'Adventure Airbnb',
                'commission_rate' => 6.00,
                'type'            => 'Airbnb',
                'contact_email'   => 'hosts@adventureairbnb.com',
                'is_active'       => true,
                'created_date'    => date('Y-m-d H:i:s'),
            ],
            [
                'name'            => 'Event Management Co',
                'commission_rate' => 10.00,
                'type'            => 'Event',
                'contact_email'   => 'events@eventmgmt.com',
                'is_active'       => true,
                'created_date'    => date('Y-m-d H:i:s'),
            ],
            [
                'name'            => 'Express Delivery',
                'commission_rate' => 4.50,
                'type'            => 'Other',
                'contact_email'   => 'contact@express.com',
                'is_active'       => true,
                'created_date'    => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('Partners')->insertBatch($data);
    }
}
