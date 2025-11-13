<?php
// 12 November 2025

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class create_locations extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'location_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'category' => [
                'type' => 'ENUM',
                'constraint' => ['Airport', 'Hotel', 'Shopping Mall', 'Hub', 'Partner_Location', 'Other'],
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'total_capacity' => [
                'type' => 'INT',
                'null' => true,
                'comment' => 'number of bags for storage locations',
            ],
            'current_occupancy' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'created_date' => [
                'type' => 'DATETIME',
                
            ],
        ]);

        $this->forge->addKey('location_id', true);
        $this->forge->addKey('category');
        $this->forge->addKey('is_active');
        $this->forge->createTable('Locations', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('Locations', true);
    }
}
