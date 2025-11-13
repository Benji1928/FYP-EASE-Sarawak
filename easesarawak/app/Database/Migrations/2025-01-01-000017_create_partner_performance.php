<?php
// 12 November 2025

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class create_partner_performance extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'performance_id' => [
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
            'period_start' => [
                'type' => 'DATE',
            ],
            'period_end' => [
                'type' => 'DATE',
            ],
            'total_bookings' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'completed_bookings' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'cancelled_bookings' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'total_revenue' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'commission_paid' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'average_rating' => [
                'type' => 'DECIMAL',
                'constraint' => '3,2',
                'null' => true,
            ],
            'created_date' => [
                'type' => 'DATETIME',
                
            ],
        ]);

        $this->forge->addKey('performance_id', true);
        $this->forge->addKey(['partner_id', 'period_start']);

        $this->forge->addForeignKey('partner_id', 'Partners', 'partner_id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('Partner_Performance', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('Partner_Performance', true);
    }
}
