<?php

namespace App\Controllers;

class AdminAnalytics extends BaseAdminController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    // Revenue analytics
    public function revenue()
    {
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-d');

        // Daily revenue
        $dailyRevenue = $this->db->query("
            SELECT
                transaction_date,
                SUM(service_revenue) as service_revenue,
                SUM(delivery_revenue) as delivery_revenue,
                SUM(insurance_revenue) as insurance_revenue,
                SUM(partner_commission) as partner_commission,
                SUM(net_revenue) as net_revenue
            FROM Revenue_Records
            WHERE transaction_date BETWEEN ? AND ?
            GROUP BY transaction_date
            ORDER BY transaction_date ASC
        ", [$startDate, $endDate])->getResult();

        // Revenue by channel
        $revenueByChannel = $this->db->query("
            SELECT
                revenue_channel,
                SUM(net_revenue) as total_revenue,
                COUNT(*) as transaction_count
            FROM Revenue_Records
            WHERE transaction_date BETWEEN ? AND ?
            GROUP BY revenue_channel
        ", [$startDate, $endDate])->getResult();

        // Revenue by service type
        $revenueByService = $this->db->query("
            SELECT
                service_type,
                SUM(net_revenue) as total_revenue,
                COUNT(*) as transaction_count
            FROM Revenue_Records
            WHERE transaction_date BETWEEN ? AND ?
            GROUP BY service_type
        ", [$startDate, $endDate])->getResult();

        $data = [
            'title' => 'Revenue Analytics',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'daily_revenue' => $dailyRevenue,
            'revenue_by_channel' => $revenueByChannel,
            'revenue_by_service' => $revenueByService,
        ];

        return view('admin/analytics/revenue', $data);
    }

    // Customer analytics
    public function customers()
    {
        // Customer lifetime value
        $topCustomers = $this->db->query("
            SELECT * FROM customer_lifetime_value
            ORDER BY total_spent DESC
            LIMIT 50
        ")->getResult();

        // Customer segmentation
        $customerByType = $this->db->query("
            SELECT
                customer_type,
                COUNT(*) as count,
                AVG(lifetime_value) as avg_lifetime_value
            FROM Users
            GROUP BY customer_type
        ")->getResult();

        // Customer acquisition trend
        $acquisitionTrend = $this->db->query("
            SELECT
                DATE_FORMAT(created_date, '%Y-%m') as month,
                source_of_booking,
                COUNT(*) as new_customers
            FROM Users
            GROUP BY month, source_of_booking
            ORDER BY month DESC
            LIMIT 12
        ")->getResult();

        $data = [
            'title' => 'Customer Analytics',
            'top_customers' => $topCustomers,
            'customer_by_type' => $customerByType,
            'acquisition_trend' => $acquisitionTrend,
        ];

        return view('admin/analytics/customers', $data);
    }

    // Operations analytics
    public function operations()
    {
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-d');

        // Daily operations summary
        $dailyOps = $this->db->query("
            SELECT * FROM daily_operations_summary
            WHERE operation_date BETWEEN ? AND ?
            ORDER BY operation_date DESC
        ", [$startDate, $endDate])->getResult();

        // Delivery performance
        $deliveryPerformance = $this->db->query("
            SELECT
                DATE(d.created_date) as date,
                COUNT(*) as total_deliveries,
                SUM(CASE WHEN d.on_time = 1 THEN 1 ELSE 0 END) as on_time_deliveries,
                AVG(d.actual_duration_minutes) as avg_duration,
                AVG(d.delay_minutes) as avg_delay
            FROM Delivery d
            WHERE DATE(d.created_date) BETWEEN ? AND ?
            GROUP BY DATE(d.created_date)
            ORDER BY date DESC
        ", [$startDate, $endDate])->getResult();

        // Storage occupancy
        $storageOccupancy = $this->db->query("
            SELECT
                name,
                category,
                total_capacity,
                current_occupancy,
                ROUND((current_occupancy / total_capacity) * 100, 2) as occupancy_rate
            FROM Locations
            WHERE category IN ('Hub', 'Airport', 'Hotel')
            AND total_capacity > 0
            ORDER BY occupancy_rate DESC
        ")->getResult();

        $data = [
            'title' => 'Operations Analytics',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'daily_ops' => $dailyOps,
            'delivery_performance' => $deliveryPerformance,
            'storage_occupancy' => $storageOccupancy,
        ];

        return view('admin/analytics/operations', $data);
    }

    // External data dashboard
    public function externalData()
    {
        // Tourist arrivals
        $touristArrivals = $this->db->table('Tourist_Arrivals_Data')
            ->orderBy('period_start', 'DESC')
            ->limit(12)
            ->get()
            ->getResult();

        // Upcoming events
        $upcomingEvents = $this->db->table('Local_Events')
            ->where('event_start_date >=', date('Y-m-d'))
            ->orderBy('event_start_date', 'ASC')
            ->limit(10)
            ->get()
            ->getResult();

        // Hotel occupancy trends
        $hotelOccupancy = $this->db->table('Hotel_Occupancy_Stats')
            ->orderBy('period_date', 'DESC')
            ->limit(30)
            ->get()
            ->getResult();

        $data = [
            'title' => 'External Data Dashboard',
            'tourist_arrivals' => $touristArrivals,
            'upcoming_events' => $upcomingEvents,
            'hotel_occupancy' => $hotelOccupancy,
        ];

        return view('admin/analytics/external_data', $data);
    }
}
