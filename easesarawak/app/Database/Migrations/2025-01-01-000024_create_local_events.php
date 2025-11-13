<?php
// 12 November 2025

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class create_local_events extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'event_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'event_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'event_type' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'comment' => 'festival, conference, sports, concert',
            ],
            'event_start_date' => [
                'type' => 'DATE',
            ],
            'event_end_date' => [
                'type' => 'DATE',
            ],
            'location' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'expected_attendance' => [
                'type' => 'INT',
                'null' => true,
            ],
            'impact_level' => [
                'type' => 'ENUM',
                'constraint' => ['low', 'medium', 'high'],
                'default' => 'medium',
            ],
            'created_date' => [
                'type' => 'DATETIME',
                
            ],
        ]);

        $this->forge->addKey('event_id', true);
        $this->forge->addKey(['event_start_date', 'event_end_date']);

        $this->forge->createTable('Local_Events', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('Local_Events', true);
    }
}
