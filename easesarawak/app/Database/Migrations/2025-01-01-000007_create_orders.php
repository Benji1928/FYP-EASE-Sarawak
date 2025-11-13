<?php
// 12 November 2025

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class create_orders extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'order_id' => [
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
            'special' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'comment' => '1 = has special handling note',
            ],
            'special_note' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'service_type' => [
                'type' => 'ENUM',
                'constraint' => ['Delivery', 'Storage', 'Storage_Delivery', 'Transfer'],
            ],
            'order_details_json' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'dropoff_time' => [
                'type' => 'DATETIME',
            ],
            'pickup_time' => [
                'type' => 'DATETIME',
            ],
            'requested_delivery_time' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'pickup_location_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null' => true,
            ],
            'dropoff_location_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'pickup_location_type' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'dropoff_location_type' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'order_status' => [
                'type' => 'ENUM',
                'constraint' => ['Pending', 'Confirmed', 'In_Storage', 'Out-for-Delivery', 'Completed', 'Cancelled'],
                'default' => 'Pending',
            ],
            'promo_code' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'is_cancelled' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'cancellation_reason' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'cancellation_time' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'base_price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'insurance_fee' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'delivery_fee' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'discount_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'total_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'number_of_bags' => [
                'type' => 'INT',
                'default' => 1,
            ],
            'has_oversized_bags' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'has_special_items' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'booking_channel' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'default' => 'direct',
                'comment' => 'direct, partner, online, walk-in',
            ],
            'booking_source' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'created_date' => [
                'type' => 'DATETIME',
                
            ],
            'updated_date' => [
                'type' => 'DATETIME',
                
                
            ],
            'modified_by' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null' => true,
            ],
            'payment_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null' => true,
            ],
            'partner_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'null' => true,
            ],
        ]);

        $this->forge->addKey('order_id', true);
        $this->forge->addKey('user_id');
        $this->forge->addKey('order_status');
        $this->forge->addKey('service_type');
        $this->forge->addKey('created_date');
        $this->forge->addKey('pickup_time');
        $this->forge->addKey('booking_channel');

        $this->forge->addForeignKey('user_id', 'Users', 'user_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('pickup_location_id', 'Locations', 'location_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('dropoff_location_id', 'Locations', 'location_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('promo_code', 'Promo', 'promo_code', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('modified_by', 'Admins', 'staff_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('payment_id', 'Payments', 'payment_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('partner_id', 'Partners', 'partner_id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('Orders', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);
    }

    public function down()
    {
        $this->forge->dropTable('Orders', true);
    }
}
