<?php
// 12 November 2025

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class create_users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'first_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'unique' => true,
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
            ],
            'social' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'social_num' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'nationality' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'customer_type' => [
                'type' => 'ENUM',
                'constraint' => ['tourist', 'business_traveller', 'event_attendee', 'medical_tourist', 'international_student', 'local'],
                'null' => true,
            ],
            'customer_segment' => [
                'type' => 'ENUM',
                'constraint' => ['short_stay', 'layover', 'long_stay'],
                'null' => true,
            ],
            'source_of_booking' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'comment' => 'online, walk-in, referral, partner',
            ],
            'how_heard_about_us' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_date' => [
                'type' => 'DATETIME',
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'updated_date' => [
                'type' => 'DATETIME',
                'default' => 'CURRENT_TIMESTAMP',
                'on_update' => 'CURRENT_TIMESTAMP',
            ],
            'total_bookings' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'lifetime_value' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'customer_acquisition_cost' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
        ]);

        $this->forge->addKey('user_id', true);
        $this->forge->addKey('customer_type');
        $this->forge->addKey('nationality');
        $this->forge->createTable('Users', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('Users', true);
    }
}
