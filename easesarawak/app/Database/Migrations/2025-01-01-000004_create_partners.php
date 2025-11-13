<?php
// 12 November 2025

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class create_partners extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'partner_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'commission_rate' => [
                'type' => 'DECIMAL',
                'constraint' => '8,2',
                'default' => 0.00,
            ],
            'type' => [
                'type' => 'ENUM',
                'constraint' => ['Hotel', 'Airbnb', 'TourAgency', 'Event', 'Airline', 'Travel_Agency', 'Other'],
            ],
            'contact_person' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'contact_email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'contact_phone' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'payment_terms' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'contract_start_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'contract_end_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_date' => [
                'type' => 'DATETIME',
                
            ],
            'updated_date' => [
                'type' => 'DATETIME',
                
                
            ],
        ]);

        $this->forge->addKey('partner_id', true);
        $this->forge->addKey('type');
        $this->forge->addKey('is_active');
        $this->forge->createTable('Partners', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('Partners', true);
    }
}
