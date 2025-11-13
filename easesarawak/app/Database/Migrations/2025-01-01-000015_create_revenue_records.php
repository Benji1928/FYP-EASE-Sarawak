<?php
// 12 November 2025

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class create_revenue_records extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'revenue_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'order_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null' => true,
            ],
            'transaction_date' => [
                'type' => 'DATE',
            ],
            'service_revenue' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'delivery_revenue' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'insurance_revenue' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'partner_commission' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'net_revenue' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'revenue_channel' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
                'comment' => 'direct, partner',
            ],
            'service_type' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'created_date' => [
                'type' => 'DATETIME',
                
            ],
        ]);

        $this->forge->addKey('revenue_id', true);
        $this->forge->addKey('transaction_date');
        $this->forge->addKey('revenue_channel');

        $this->forge->addForeignKey('order_id', 'Orders', 'order_id', 'SET NULL', 'CASCADE');

        $this->forge->createTable('Revenue_Records', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('Revenue_Records', true);
    }
}
