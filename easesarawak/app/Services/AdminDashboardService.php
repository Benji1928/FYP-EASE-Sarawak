<?php

namespace App\Services;

use CodeIgniter\Database\BaseConnection;

class AdminDashboardService
{
    /**
     * @var BaseConnection
     */
    protected $db;

    public function __construct(?BaseConnection $db = null)
    {
        $this->db = $db ?? \Config\Database::connect();
    }

    public function getDashboardStats(): array
    {
        // User Metrics
        $totalUsers = $this->db->table('Users')->countAll();
        $activeUsers = $this->db->table('Users')
            ->where('is_active', true)
            ->countAllResults();
        $newUsersThisMonth = $this->db->table('Users')
            ->where('DATE_FORMAT(created_date, "%Y-%m")', date('Y-m'))
            ->countAllResults();

        // Order Metrics
        $totalOrders = $this->db->table('Orders')->countAll();
        $ordersToday = $this->db->table('Orders')
            ->where('DATE(created_date)', date('Y-m-d'))
            ->countAllResults();
        $ordersByStatus = $this->db->query("
            SELECT order_status, COUNT(*) as count
            FROM Orders
            GROUP BY order_status
        ")->getResultArray();

        $orderStatusCounts = [];
        foreach ($ordersByStatus as $status) {
            $orderStatusCounts[$status['order_status']] = $status['count'];
        }

        // Financial Metrics
        $revenueThisMonthRow = $this->db->table('Orders')
            ->select('SUM(total_amount) as total')
            ->where('DATE_FORMAT(created_date, "%Y-%m")', date('Y-m'))
            ->where('order_status !=', 'Cancelled')
            ->get()
            ->getRow();
        $revenueThisMonth = $revenueThisMonthRow->total ?? 0;

        $totalRevenueRow = $this->db->table('Orders')
            ->select('SUM(total_amount) as total')
            ->where('order_status !=', 'Cancelled')
            ->get()
            ->getRow();
        $totalRevenue = $totalRevenueRow->total ?? 0;

        // Payment Status
        $paymentStats = $this->db->query("
            SELECT status, COUNT(*) as count, SUM(amount) as total_amount
            FROM Payments
            GROUP BY status
        ")->getResultArray();

        $paymentStatusData = [];
        foreach ($paymentStats as $payment) {
            $paymentStatusData[$payment['status']] = [
                'count' => $payment['count'],
                'amount' => $payment['total_amount'] ?? 0,
            ];
        }

        // Delivery Metrics
        $pendingDeliveries = $this->db->table('Delivery')
            ->whereIn('status', ['Pending', 'Assigned', 'On Route'])
            ->countAllResults();

        $onTimeDeliveries = $this->db->table('Delivery')
            ->where('on_time', true)
            ->where('status', 'Delivered')
            ->countAllResults();

        $totalDeliveries = $this->db->table('Delivery')
            ->where('status', 'Delivered')
            ->countAllResults();

        $onTimeRate = $totalDeliveries > 0
            ? round(($onTimeDeliveries / $totalDeliveries) * 100, 2)
            : 0;

        // Partner Metrics
        $activePartners = $this->db->table('Partners')
            ->where('is_active', true)
            ->countAllResults();

        $partnersByType = $this->db->query("
            SELECT type, COUNT(*) as count
            FROM Partners
            WHERE is_active = 1
            GROUP BY type
        ")->getResultArray();

        // Storage Metrics
        $storageStats = $this->db->query("
            SELECT
                SUM(total_capacity) as total_capacity,
                SUM(current_occupancy) as current_occupancy
            FROM Locations
            WHERE category IN ('Hub', 'Airport', 'Hotel')
        ")->getRow();

        $occupancyRate = ($storageStats->total_capacity ?? 0) > 0
            ? round(($storageStats->current_occupancy / $storageStats->total_capacity) * 100, 2)
            : 0;

        // Incidents & Claims
        $openIncidents = $this->db->table('Incidents')
            ->whereIn('status', ['reported', 'investigating'])
            ->countAllResults();

        $pendingClaims = $this->db->table('Insurance_Claims')
            ->whereIn('claim_status', ['submitted', 'under_review'])
            ->countAllResults();

        // Service Type Distribution
        $serviceTypeStats = $this->db->query("
            SELECT service_type, COUNT(*) as count
            FROM Orders
            WHERE order_status != 'Cancelled'
            GROUP BY service_type
        ")->getResultArray();

        // Average Order Value
        $avgOrderValueRow = $this->db->table('Orders')
            ->select('AVG(total_amount) as avg')
            ->where('order_status !=', 'Cancelled')
            ->get()
            ->getRow();
        $avgOrderValue = $avgOrderValueRow->avg ?? 0;

        // Customer Ratings
        $avgRating = $this->db->table('Reviews')
            ->select('AVG(rating) as avg_rating, COUNT(*) as total_reviews')
            ->get()
            ->getRow();

        // Staff Count
        $activeStaff = $this->db->table('Admins')
            ->where('is_active', true)
            ->countAllResults();

        return [
            'total_users' => $totalUsers,
            'active_users' => $activeUsers,
            'new_users_month' => $newUsersThisMonth,
            'total_orders' => $totalOrders,
            'orders_today' => $ordersToday,
            'pending_orders' => $orderStatusCounts['Pending'] ?? 0,
            'confirmed_orders' => $orderStatusCounts['Confirmed'] ?? 0,
            'in_storage_orders' => $orderStatusCounts['In_Storage'] ?? 0,
            'out_for_delivery' => $orderStatusCounts['Out-for-Delivery'] ?? 0,
            'completed_orders' => $orderStatusCounts['Completed'] ?? 0,
            'cancelled_orders' => $orderStatusCounts['Cancelled'] ?? 0,
            'revenue_month' => $revenueThisMonth,
            'total_revenue' => $totalRevenue,
            'avg_order_value' => $avgOrderValue,
            'pending_payments' => $paymentStatusData['Pending']['count'] ?? 0,
            'pending_payment_amount' => $paymentStatusData['Pending']['amount'] ?? 0,
            'failed_payments' => $paymentStatusData['Failed']['count'] ?? 0,
            'pending_deliveries' => $pendingDeliveries,
            'on_time_rate' => $onTimeRate,
            'active_partners' => $activePartners,
            'partners_by_type' => $partnersByType,
            'occupancy_rate' => $occupancyRate,
            'current_occupancy' => $storageStats->current_occupancy ?? 0,
            'total_capacity' => $storageStats->total_capacity ?? 0,
            'open_incidents' => $openIncidents,
            'pending_claims' => $pendingClaims,
            'avg_rating' => round($avgRating->avg_rating ?? 0, 2),
            'total_reviews' => $avgRating->total_reviews ?? 0,
            'service_type_stats' => $serviceTypeStats,
            'active_staff' => $activeStaff,
        ];
    }

    public function getRecentOrders(int $limit = 10): array
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

    public function getRevenueChartData(): array
    {
        $last7Days = $this->db->query("
            SELECT
                DATE(created_date) as date,
                SUM(total_amount) as revenue
            FROM Orders
            WHERE created_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                AND order_status != 'Cancelled'
            GROUP BY DATE(created_date)
            ORDER BY date ASC
        ")->getResult();

        return [
            'labels' => array_map(static fn($r) => date('M d', strtotime($r->date)), $last7Days),
            'data' => array_map(static fn($r) => (float) $r->revenue, $last7Days),
        ];
    }

    public function getTopCustomers(int $limit = 5): array
    {
        return $this->db->query("
            SELECT
                u.user_id,
                u.first_name,
                u.last_name,
                u.email,
                COUNT(o.order_id) as total_orders,
                SUM(o.total_amount) as total_spent,
                u.lifetime_value
            FROM Users u
            LEFT JOIN Orders o ON o.user_id = u.user_id AND o.order_status != 'Cancelled'
            WHERE u.is_active = 1
            GROUP BY u.user_id
            ORDER BY total_spent DESC
            LIMIT " . (int) $limit
        )->getResult();
    }

    public function getRecentIncidents(int $limit = 5): array
    {
        return $this->db->query("
            SELECT
                i.incident_id,
                i.incident_type,
                i.incident_date,
                i.severity,
                i.status,
                i.description,
                o.order_id,
                CONCAT(u.first_name, ' ', u.last_name) as customer_name
            FROM Incidents i
            LEFT JOIN Orders o ON o.order_id = i.order_id
            LEFT JOIN Users u ON u.user_id = o.user_id
            ORDER BY i.incident_date DESC
            LIMIT " . (int) $limit
        )->getResult();
    }

    public function getStaffPerformance(int $limit = 5): array
    {
        return $this->db->query("
            SELECT
                a.staff_id,
                a.staff_name,
                a.role,
                COUNT(DISTINCT d.delivery_id) as total_deliveries,
                AVG(CASE WHEN d.on_time = 1 THEN 100 ELSE 0 END) as on_time_percentage,
                SUM(d.distance_km) as total_distance
            FROM Admins a
            LEFT JOIN Delivery d ON d.driver_id = a.staff_id AND d.status = 'Delivered'
            WHERE a.is_active = 1 AND a.role = 'Driver'
            GROUP BY a.staff_id
            ORDER BY total_deliveries DESC
            LIMIT " . (int) $limit
        )->getResult();
    }

    public function getBookingChannelStats(): array
    {
        return $this->db->query("
            SELECT
                booking_channel,
                COUNT(*) as count,
                SUM(total_amount) as revenue
            FROM Orders
            WHERE order_status != 'Cancelled'
            GROUP BY booking_channel
            ORDER BY count DESC
        ")->getResult();
    }

    public function getCustomerTypeStats(): array
    {
        return $this->db->query("
            SELECT
                customer_type,
                COUNT(*) as count,
                COUNT(DISTINCT user_id) as unique_users
            FROM Users
            WHERE is_active = 1
            GROUP BY customer_type
            ORDER BY count DESC
        ")->getResult();
    }
}
