<?php
// 12 November 2025

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class create_reviews extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'review_id' => [
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
            'user_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null' => true,
            ],
            'rating' => [
                'type' => 'TINYINT',
                'constraint' => 3,
            ],
            'comment' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'source' => [
                'type' => 'ENUM',
                'constraint' => ['Google', 'Website', 'Facebook', 'Others'],
                'default' => 'Others',
            ],
            'external_link' => [
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => true,
            ],
            'response_text' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'response_date' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'is_public' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'created_date' => [
                'type' => 'DATETIME',
                
            ],
        ]);

        $this->forge->addKey('review_id', true);
        $this->forge->addKey('rating');
        $this->forge->addKey('source');

        $this->forge->addForeignKey('order_id', 'Orders', 'order_id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'Users', 'user_id', 'SET NULL', 'CASCADE');

        $this->forge->createTable('Reviews', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('Reviews', true);
    }
}
