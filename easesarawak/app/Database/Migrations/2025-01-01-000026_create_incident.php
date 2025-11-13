<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIncidentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'incident_id' => [
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
            'incident_type' => [
                'type' => 'ENUM',
                'constraint' => ['lost', 'damaged', 'delayed', 'theft', 'security_breach', 'other'],
            ],
            'incident_date' => [
                'type' => 'DATETIME',
            ],
            'incident_location' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'severity' => [
                'type' => 'ENUM',
                'constraint' => ['low', 'medium', 'high', 'critical'],
                'default' => 'medium',
            ],
            'description' => [
                'type' => 'TEXT',
            ],
            'cause' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'reported_by_user_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null' => true,
            ],
            'reported_by_staff_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['reported', 'investigating', 'resolved', 'closed'],
                'default' => 'reported',
            ],
            'resolution_notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'resolved_date' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'estimated_cost' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'actual_cost' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'created_date' => [
                'type' => 'DATETIME',
                
            ],
            'updated_date' => [
                'type' => 'DATETIME',
                
                
            ],
        ]);

        $this->forge->addKey('incident_id', true);
        $this->forge->addKey('incident_type');
        $this->forge->addKey('incident_date');
        $this->forge->addKey('status');

        $this->forge->addForeignKey('order_id', 'Orders', 'order_id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('reported_by_user_id', 'Users', 'user_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('reported_by_staff_id', 'Admins', 'staff_id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('Incidents', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('Incidents', true);
    }
}
