<?php
// 12 November 2025

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class create_insurance_claim extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'claim_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'incident_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null' => true,
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
            'claim_reference' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'unique' => true,
            ],
            'claim_date' => [
                'type' => 'DATE',
            ],
            'claim_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'claim_status' => [
                'type' => 'ENUM',
                'constraint' => ['submitted', 'under_review', 'approved', 'paid', 'rejected'],
                'default' => 'submitted',
            ],
            'insurance_provider' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'policy_number' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'coverage_type' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'approved_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'payout_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'payout_reference' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'supporting_documents' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'notes' => [
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

        $this->forge->addKey('claim_id', true);
        $this->forge->addKey('claim_status');

        $this->forge->addForeignKey('incident_id', 'Incidents', 'incident_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('order_id', 'Orders', 'order_id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'Users', 'user_id', 'SET NULL', 'CASCADE');

        $this->forge->createTable('Insurance_Claims', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('Insurance_Claims', true);
    }
}
