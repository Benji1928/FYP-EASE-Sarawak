<?php
// 12 November 2025

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLuggageItemsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'item_id' => [
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
            'size' => [
                'type' => 'ENUM',
                'constraint' => ['Small', 'Medium', 'Large', 'Oversized'],
            ],
            'insured' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'insurance_value' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'special_request' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'item_tag' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'comment' => 'Physical tag/barcode number',
            ],
            'weight_kg' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('item_id', true);
        $this->forge->addForeignKey('order_id', 'Orders', 'order_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('LuggageItems', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('LuggageItems', true);
    }
}
