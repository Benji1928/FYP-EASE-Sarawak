<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Admins_seeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'staff_name'      => 'Admin User',
                'password'        => password_hash('admin123', PASSWORD_BCRYPT),
                'email'           => 'admin@easesarawak.com',
                'role'            => 'Admin',
                'employment_type' => 'full_time',
                'hire_date'       => '2024-01-15',
                'created_date'    => date('Y-m-d H:i:s'),
            ],
            [
                'staff_name'      => 'Super Admin',
                'password'        => password_hash('superadmin123', PASSWORD_BCRYPT),
                'email'           => 'superadmin@easesarawak.com',
                'role'            => 'Superadmin',
                'employment_type' => 'full_time',
                'hire_date'       => '2023-12-01',
                'created_date'    => date('Y-m-d H:i:s'),
            ],
            [
                'staff_name'      => 'Driver Ahmad',
                'password'        => password_hash('driver123', PASSWORD_BCRYPT),
                'email'           => 'driver1@easesarawak.com',
                'role'            => 'Driver',
                'employment_type' => 'full_time',
                'hire_date'       => '2024-02-01',
                'created_date'    => date('Y-m-d H:i:s'),
            ],
            [
                'staff_name'      => 'Sarah Handler',
                'password'        => password_hash('handler123', PASSWORD_BCRYPT),
                'email'           => 'handler1@easesarawak.com',
                'role'            => 'Storage_Handler',
                'employment_type' => 'part_time',
                'hire_date'       => '2024-03-15',
                'created_date'    => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('Admins')->insertBatch($data);
    }
}
