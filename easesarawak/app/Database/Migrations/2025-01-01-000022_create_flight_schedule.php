<?php

// 12 November 2025

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class create_flight_schedule extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'schedule_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'airport_code' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'default' => 'KCH',
            ],
            'flight_number' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'airline' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'flight_type' => [
                'type' => 'ENUM',
                'constraint' => ['arrival', 'departure'],
            ],
            'origin_destination' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'scheduled_time' => [
                'type' => 'DATETIME',
            ],
            'actual_time' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'default' => 'scheduled',
            ],
            'passenger_capacity' => [
                'type' => 'INT',
                'null' => true,
            ],
            'created_date' => [
                'type' => 'DATETIME',
                
            ],
        ]);

        $this->forge->addKey('schedule_id', true);
        $this->forge->addKey('scheduled_time');
        $this->forge->addKey('flight_type');
        $this->forge->addUniqueKey(['flight_number', 'scheduled_time']);

        $this->forge->createTable('Flight_Schedules', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('Flight_Schedules', true);
    }
}
