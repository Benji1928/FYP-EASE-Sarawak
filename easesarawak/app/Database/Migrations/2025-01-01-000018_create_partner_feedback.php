<?php
// 12 November 2025

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class create_partner_feedback extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'feedback_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'partner_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
            ],
            'feedback_date' => [
                'type' => 'DATE',
            ],
            'feedback_type' => [
                'type' => 'ENUM',
                'constraint' => ['complaint', 'suggestion', 'praise'],
            ],
            'feedback_text' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'resolved' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'created_date' => [
                'type' => 'DATETIME',
                
            ],
        ]);

        $this->forge->addKey('feedback_id', true);
        $this->forge->addForeignKey('partner_id', 'Partners', 'partner_id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('Partner_Feedback', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('Partner_Feedback', true);
    }
}
