<?php
// 12 November 2025

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class create_index extends Migration
{
    public function up()
    {
        // Additional indexes for Orders table - using raw columns instead of expressions
        $this->db->query("CREATE INDEX idx_orders_pickup_date ON Orders(pickup_time)");
        $this->db->query("CREATE INDEX idx_orders_created_date ON Orders(created_date)");

        // Additional indexes for Revenue_Records table
        $this->db->query("CREATE INDEX idx_revenue_transaction_date ON Revenue_Records(transaction_date)");

        // Additional indexes for Tourist_Arrivals_Data table
        $this->db->query("CREATE INDEX idx_tourist_period ON Tourist_Arrivals_Data(period_start, location)");

        // Additional indexes for Flight_Schedules table
        $this->db->query("CREATE INDEX idx_flights_scheduled_time ON Flight_Schedules(scheduled_time)");
    }

    public function down()
    {
        // Drop additional indexes
        $this->db->query("DROP INDEX idx_orders_pickup_date ON Orders");
        $this->db->query("DROP INDEX idx_orders_created_date ON Orders");
        $this->db->query("DROP INDEX idx_revenue_transaction_date ON Revenue_Records");
        $this->db->query("DROP INDEX idx_tourist_period ON Tourist_Arrivals_Data");
        $this->db->query("DROP INDEX idx_flights_scheduled_time ON Flight_Schedules");
    }
}
