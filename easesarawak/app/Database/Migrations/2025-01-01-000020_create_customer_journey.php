<?php
// 12 November 2025

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class create_customer_journey extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'journey_id' => [
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
            'order_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null' => true,
            ],
            'awareness_source' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'first_interaction_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'first_booking_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'website_visits' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'email_opens' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'email_clicks' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'service_tier_used' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'satisfaction_score' => [
                'type' => 'INT',
                'null' => true,
            ],
            'created_date' => [
                'type' => 'DATETIME',
                
            ],
        ]);

        $this->forge->addKey('journey_id', true);
        $this->forge->addForeignKey('user_id', 'Users', 'user_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('order_id', 'Orders', 'order_id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('Customer_Journey', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('Customer_Journey', true);
    }
}
