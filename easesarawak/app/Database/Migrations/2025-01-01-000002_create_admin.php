<?php
// 12 November 2025

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class create_admin extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'staff_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'staff_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'unique' => true,
            ],
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['Admin', 'Superadmin', 'Driver', 'Storage_Handler', 'Customer_Service'],
                'default' => 'Admin',
            ],
            'employment_type' => [
                'type' => 'ENUM',
                'constraint' => ['full_time', 'part_time', 'contractor'],
                'default' => 'full_time',
            ],
            'hire_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'created_date' => [
                'type' => 'DATETIME',
                
            ],
            'modified_date' => [
                'type' => 'DATETIME',
                
                
            ],
        ]);

        $this->forge->addKey('staff_id', true);
        $this->forge->addKey('role');
        $this->forge->addKey('is_active');
        $this->forge->createTable('Admins', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('Admins', true);
    }
}
