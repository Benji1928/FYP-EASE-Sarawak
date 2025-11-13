<?php
// 12 November 2025

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class create_hotel_occupancy extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'occupancy_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'period_date' => [
                'type' => 'DATE',
            ],
            'location' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => 'Kuching',
            ],
            'average_occupancy_rate' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true,
            ],
            'total_rooms_available' => [
                'type' => 'INT',
                'null' => true,
            ],
            'rooms_occupied' => [
                'type' => 'INT',
                'null' => true,
            ],
            'data_source' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'created_date' => [
                'type' => 'DATETIME',
                
            ],
        ]);

        $this->forge->addKey('occupancy_id', true);
        $this->forge->addKey('period_date');

        $this->forge->createTable('Hotel_Occupancy_Stats', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('Hotel_Occupancy_Stats', true);
    }
}
