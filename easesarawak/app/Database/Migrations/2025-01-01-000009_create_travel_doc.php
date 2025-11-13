<?php
// 12 November 2025

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class create_travel_doc extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'doc_id' => [
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
            'doc_type' => [
                'type' => 'ENUM',
                'constraint' => ['Passport', 'Visa', 'Ticket', 'Insurance', 'Other'],
            ],
            'file_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'file_path' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'uploaded_date' => [
                'type' => 'DATETIME',
                
            ],
            'verified' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'verified_by' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null' => true,
            ],
            'verified_date' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('doc_id', true);
        $this->forge->addForeignKey('order_id', 'Orders', 'order_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('verified_by', 'Admins', 'staff_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Travel_Documents', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('Travel_Documents', true);
    }
}
