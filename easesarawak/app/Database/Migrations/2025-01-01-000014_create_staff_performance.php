<?php
// 12 November 2025

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class create_staff_performance extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'performance_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'staff_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'performance_date' => [
                'type' => 'DATE',
            ],
            'deliveries_completed' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'pickups_completed' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'average_delivery_time_minutes' => [
                'type' => 'INT',
                'null' => true,
            ],
            'on_time_rate' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true,
            ],
            'bags_processed' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'incidents_reported' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'shift_start_time' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'shift_end_time' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'hours_worked' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_date' => [
                'type' => 'DATETIME',
                
            ],
        ]);

        $this->forge->addKey('performance_id', true);
        $this->forge->addKey(['staff_id', 'performance_date']);

        $this->forge->addForeignKey('staff_id', 'Admins', 'staff_id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('Staff_Performance', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('Staff_Performance', true);
    }
}
