<?php
// 12 November 2025

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class create_delivery extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'delivery_id' => [
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
            'driver_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Pending', 'Assigned', 'On Route', 'Delivered', 'Failed'],
                'default' => 'Pending',
            ],
            'assigned_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'pickup_started_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'pickup_completed_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'delivery_started_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'completed_time' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'estimated_duration_minutes' => [
                'type' => 'INT',
                'null' => true,
            ],
            'actual_duration_minutes' => [
                'type' => 'INT',
                'null' => true,
            ],
            'distance_km' => [
                'type' => 'DECIMAL',
                'constraint' => '8,2',
                'null' => true,
            ],
            'on_time' => [
                'type' => 'BOOLEAN',
                'null' => true,
            ],
            'delay_minutes' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'delivery_notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_date' => [
                'type' => 'TIMESTAMP',
            ],
        ]);

        $this->forge->addKey('delivery_id', true);
        $this->forge->addKey('driver_id');
        $this->forge->addKey('status');

        $this->forge->addForeignKey('order_id', 'Orders', 'order_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('driver_id', 'Admins', 'staff_id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('Delivery', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('Delivery', true);
    }
}
