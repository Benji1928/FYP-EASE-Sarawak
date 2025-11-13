<?php
// 12 November 2025

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class create_marketing_campaigns extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'campaign_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'campaign_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'campaign_type' => [
                'type' => 'ENUM',
                'constraint' => ['email', 'social_media', 'partnership', 'paid_ads', 'referral'],
            ],
            'start_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'end_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'budget' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'total_spend' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'impressions' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'clicks' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'conversions' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'revenue_generated' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'created_date' => [
                'type' => 'DATETIME',
                
            ],
        ]);

        $this->forge->addKey('campaign_id', true);
        $this->forge->addKey(['start_date', 'end_date']);

        $this->forge->createTable('Marketing_Campaigns', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('Marketing_Campaigns', true);
    }
}
