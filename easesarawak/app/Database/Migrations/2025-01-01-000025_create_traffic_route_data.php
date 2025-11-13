<?php
// 12 November 2025

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class create_traffic_route_data extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'traffic_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'route_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'origin_location' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'destination_location' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'log_datetime' => [
                'type' => 'DATETIME',
            ],
            'average_travel_time_minutes' => [
                'type' => 'INT',
                'null' => true,
            ],
            'distance_km' => [
                'type' => 'DECIMAL',
                'constraint' => '8,2',
                'null' => true,
            ],
            'traffic_condition' => [
                'type' => 'ENUM',
                'constraint' => ['light', 'moderate', 'heavy', 'severe'],
                'default' => 'moderate',
            ],
            'created_date' => [
                'type' => 'DATETIME',
                
            ],
        ]);

        $this->forge->addKey('traffic_id', true);
        $this->forge->addKey('log_datetime');

        $this->forge->createTable('Traffic_Route_Data', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('Traffic_Route_Data', true);
    }
}
