<?php

namespace App\Controllers;

use App\Services\AdminDashboardService;

class AdminDashboard extends BaseAdminController
{
    /**
     * @var AdminDashboardService|null
     */
    protected $dashboardService;

    protected function dashboardService(): AdminDashboardService
    {
        if ($this->dashboardService === null) {
            $this->dashboardService = new AdminDashboardService();
        }

        return $this->dashboardService;
    }

    public function index()
    {
        $service = $this->dashboardService();

        $data = [
            'title' => 'Dashboard Overview',
            'stats' => $service->getDashboardStats(),
            'recent_orders' => $service->getRecentOrders(5),
            'revenue_chart' => $service->getRevenueChartData(),
        ];

        return view('admin/dashboard', $data);
    }

    public function overview()
    {
        return $this->index();
    }

    public function orders()
    {
        $service = $this->dashboardService();

        $data = [
            'title' => 'Orders Management',
            'stats' => $service->getDashboardStats(),
            'recent_orders' => $service->getRecentOrders(20),
            'revenue_chart' => $service->getRevenueChartData(),
        ];

        return view('admin/orders/orders_dashboard', $data);
    }

    public function customers()
    {
        $service = $this->dashboardService();

        $data = [
            'title' => 'Customer Analytics',
            'stats' => $service->getDashboardStats(),
            'top_customers' => $service->getTopCustomers(10),
            'customer_types' => $service->getCustomerTypeStats(),
            'booking_channels' => $service->getBookingChannelStats(),
        ];

        return view('admin/customer', $data);
    }

    public function operations()
    {
        $service = $this->dashboardService();

        $data = [
            'title' => 'Operations Dashboard',
            'stats' => $service->getDashboardStats(),
            'staff_performance' => $service->getStaffPerformance(10),
            'recent_incidents' => $service->getRecentIncidents(10),
        ];

        return view('admin/management/operations', $data);
    }
}
