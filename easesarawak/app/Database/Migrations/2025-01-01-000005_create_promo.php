<?php
// 12 November 2025

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class create_promo extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'promo_code' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'discount_type' => [
                'type' => 'ENUM',
                'constraint' => ['Flat', 'Percent'],
            ],
            'discount_value' => [
                'type' => 'DECIMAL',
                'constraint' => '8,2',
            ],
            'start_date' => [
                'type' => 'DATETIME',
            ],
            'end_date' => [
                'type' => 'DATETIME',
            ],
            'usage_limit' => [
                'type' => 'INT',
                'null' => true,
                'comment' => 'NULL = unlimited',
            ],
            'times_used' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'created_date' => [
                'type' => 'DATETIME',
                
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'comment' => 'Tracks which admin created the promo',
            ],
        ]);

        $this->forge->addKey('promo_code', true);
        $this->forge->addForeignKey('created_by', 'Admins', 'staff_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Promo', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('Promo', true);
    }
}
