<?php
// 12 November 2025

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class create_operational_cost extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'cost_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'cost_date' => [
                'type' => 'DATE',
            ],
            'cost_category' => [
                'type' => 'ENUM',
                'constraint' => ['hub_operation', 'logistics', 'marketing', 'staff', 'maintenance', 'utilities', 'other'],
            ],
            'cost_subcategory' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'amount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'is_recurring' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'created_date' => [
                'type' => 'DATETIME',
                
            ],
        ]);

        $this->forge->addKey('cost_id', true);
        $this->forge->addKey('cost_date');
        $this->forge->addKey('cost_category');

        $this->forge->createTable('Operational_Costs', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('Operational_Costs', true);
    }
}
