<?php
// 12 November 2025

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class create_social_contacts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'social_contact_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'platform' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'comment' => 'whatsapp, wechat, line, telegram',
            ],
            'contact_handle' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'is_primary' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'created_date' => [
                'type' => 'DATETIME',
                
            ],
        ]);

        $this->forge->addKey('social_contact_id', true);
        $this->forge->addForeignKey('user_id', 'Users', 'user_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('User_Social_Contacts', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('User_Social_Contacts', true);
    }
}
