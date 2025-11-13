<?php
// 12 November 2025

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class create_storage_tracking extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'tracking_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'order_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'location_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null' => true,
            ],
            'check_in_time' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'storage_start_time' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'storage_end_time' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'pickup_time' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'checked_in_by' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null' => true,
            ],
            'retrieved_by' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null' => true,
            ],
            'storage_notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_date' => [
                'type' => 'DATETIME',
                
            ],
        ]);

        $this->forge->addKey('tracking_id', true);
        $this->forge->addKey('order_id');
        $this->forge->addKey('location_id');

        $this->forge->addForeignKey('order_id', 'Orders', 'order_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('location_id', 'Locations', 'location_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('checked_in_by', 'Admins', 'staff_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('retrieved_by', 'Admins', 'staff_id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('Storage_Tracking', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('Storage_Tracking', true);
    }
}
