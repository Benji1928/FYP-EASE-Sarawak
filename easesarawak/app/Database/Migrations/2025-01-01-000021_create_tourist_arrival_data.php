<?php
// 12 November 2025

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class create_tourist_arrival_data extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'arrival_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'period_start' => [
                'type' => 'DATE',
            ],
            'period_end' => [
                'type' => 'DATE',
            ],
            'location' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => 'Kuching',
            ],
            'total_arrivals' => [
                'type' => 'INT',
                'null' => true,
            ],
            'international_arrivals' => [
                'type' => 'INT',
                'null' => true,
            ],
            'domestic_arrivals' => [
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

        $this->forge->addKey('arrival_id', true);
        $this->forge->addKey('period_start');
        $this->forge->addUniqueKey(['period_start', 'location']);

        $this->forge->createTable('Tourist_Arrivals_Data', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('Tourist_Arrivals_Data', true);
    }
}
