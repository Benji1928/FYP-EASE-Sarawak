<?php

namespace App\Controllers;

class AdminDashboard extends BaseAdminController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data = [
            'title' => 'Admin Dashboard',
            'stats' => $this->getDashboardStats(),
            'recent_orders' => $this->getRecentOrders(),
            'revenue_chart' => $this->getRevenueChartData(),
        ];

        return view('admin/dashboard', $data);
    }

    private function getDashboardStats()
    {
        // Total users
        $totalUsers = $this->db->table('Users')->countAll();

        // Total orders today
        $ordersToday = $this->db->table('Orders')
            ->where('DATE(created_date)', date('Y-m-d'))
            ->countAllResults();

        // Revenue this month
        $revenueThisMonth = $this->db->table('Revenue_Records')
            ->select('SUM(net_revenue) as total')
            ->where('DATE_FORMAT(transaction_date, "%Y-%m")', date('Y-m'))
            ->get()
            ->getRow()
            ->total ?? 0;

        // Pending deliveries
        $pendingDeliveries = $this->db->table('Delivery')
            ->whereIn('status', ['Pending', 'Assigned', 'On Route'])
            ->countAllResults();

        // Active partners
        $activePartners = $this->db->table('Partners')
            ->where('is_active', true)
            ->countAllResults();

        // Storage occupancy
        $storageStats = $this->db->query("
            SELECT
                SUM(total_capacity) as total_capacity,
                SUM(current_occupancy) as current_occupancy
            FROM Locations
            WHERE category IN ('Hub', 'Airport', 'Hotel')
        ")->getRow();

        $occupancyRate = $storageStats->total_capacity > 0
            ? round(($storageStats->current_occupancy / $storageStats->total_capacity) * 100, 2)
            : 0;

        return [
            'total_users' => $totalUsers,
            'orders_today' => $ordersToday,
            'revenue_month' => number_format($revenueThisMonth, 2),
            'pending_deliveries' => $pendingDeliveries,
            'active_partners' => $activePartners,
            'occupancy_rate' => $occupancyRate,
        ];
    }

    private function getRecentOrders($limit = 10)
    {
        return $this->db->table('Orders o')
            ->select('o.order_id, o.order_status, o.total_amount, o.created_date,
                      u.first_name, u.last_name, u.email')
            ->join('Users u', 'u.user_id = o.user_id')
            ->orderBy('o.created_date', 'DESC')
            ->limit($limit)
            ->get()
            ->getResult();
    }

    private function getRevenueChartData()
    {
        $last7Days = $this->db->query("
            SELECT
                DATE(transaction_date) as date,
                SUM(net_revenue) as revenue
            FROM Revenue_Records
            WHERE transaction_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
            GROUP BY DATE(transaction_date)
            ORDER BY date ASC
        ")->getResult();

        return [
            'labels' => array_map(fn($r) => date('M d', strtotime($r->date)), $last7Days),
            'data' => array_map(fn($r) => floatval($r->revenue), $last7Days),
        ];
    }
}
