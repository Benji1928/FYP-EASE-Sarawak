<?php
// 12 November 2025

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class create_payments extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'payment_id' => [
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
            'amount' => [
                'type' => 'DECIMAL',
                'constraint' => '8,2',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Pending', 'Paid', 'Failed', 'Refunded'],
                'default' => 'Pending',
            ],
            'method' => [
                'type' => 'ENUM',
                'constraint' => ['Card', 'Online Transaction', 'Cash', 'Bank_Transfer', 'E-Wallet'],
            ],
            'transaction_ref' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'unique' => true,
            ],
            'paid_time' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'payment_gateway' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'invoice_number' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'currency' => [
                'type' => 'VARCHAR',
                'constraint' => '3',
                'default' => 'MYR',
            ],
            'refund_reason' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'refund_time' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_date' => [
                'type' => 'TIMESTAMP',
            ],
        ]);

        $this->forge->addKey('payment_id', true);
        $this->forge->addKey('status');
        $this->forge->createTable('Payments', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('Payments', true);
    }
}
