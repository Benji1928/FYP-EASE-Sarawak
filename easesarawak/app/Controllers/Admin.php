<?php

namespace App\Controllers;

use App\Models\Order_model;
use App\Models\User_model;
use App\Services\AdminDashboardService;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Admin extends BaseController
{
    public $data = [];
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

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $session = session();
        $access = $session->get('access');
        $role = $session->get('role');

        if (empty($access) || ($role !== '1' && $role !== '0')) {
            header('Location: ' . base_url('login'));
            exit;
        } else {
            $this->data['username'] = $session->get('username');
        }
    }

    public function index(): string
    {
        $order_model = new Order_model();
        $user_model = new User_model();

        $order = $order_model->countAllResults();
        $user  = $user_model->countAllResults();
        $sales = $order_model
            ->selectSum('total_amount')
            ->get()
            ->getRow()
            ->total_amount ?? 0;
        $totalOrders = $order_model->countAllResults();

        // Fetch all pending orders with user information
        $db = \Config\Database::connect();
        $pending_orders = $db->table('Orders')
            ->select('Orders.*, Users.first_name, Users.last_name, Users.email, Users.phone')
            ->join('Users', 'Users.user_id = Orders.user_id', 'left')
            ->where('Orders.order_status', 'Pending')
            ->get()
            ->getResultArray();

        $dashboardService = $this->dashboardService();

        $data = [
            'order_count' => $order,
            'user_count' => $user,
            'sales' => $sales,
            'orders' => $totalOrders,
            'pending_orders' => $pending_orders,
            'stats' => $dashboardService->getDashboardStats(),
            'recent_orders' => $dashboardService->getRecentOrders(),
            'revenue_chart' => $dashboardService->getRevenueChartData(),
            'top_customers' => $dashboardService->getTopCustomers(),
            'recent_incidents' => $dashboardService->getRecentIncidents(),
            'staff_performance' => $dashboardService->getStaffPerformance(),
            'booking_channels' => $dashboardService->getBookingChannelStats(),
            'customer_types' => $dashboardService->getCustomerTypeStats(),
        ];

        return view('admin/dashboard', $data);
    }

    public function report()
    {
        $order_model = new Order_model();

        // Total Revenue (sum of all order amounts)
        $totalRevenue = $order_model
            ->selectSum('total_amount')
            ->get()
            ->getRow()
            ->total_amount ?? 0;

        // Total Orders (count)
        $totalOrders = $order_model->countAllResults();

        // Revenue Breakdown (Last 6 Months)
        $db = \Config\Database::connect();
        $builder = $db->table('Orders');

        // select only aggregated or grouped expressions — no plain columns
        $builder->select("DATE_FORMAT(MIN(created_date), '%b %Y') AS month, SUM(total_amount) AS total");
        $builder->where('created_date >=', date('Y-m-01', strtotime('-5 months')));
        $builder->groupBy("YEAR(created_date), MONTH(created_date)");
        $builder->orderBy("YEAR(created_date)", 'ASC');
        $builder->orderBy("MONTH(created_date)", 'ASC');

        $revenueQuery = $builder->get()->getResultArray();

        $months   = array_column($revenueQuery, 'month');
        $revenues = array_map('floatval', array_column($revenueQuery, 'total'));

        // Peak Booking Times (based on created_date hour)
        $builder2 = $db->table('Orders');
        $builder2->select("HOUR(created_date) AS hour, COUNT(order_id) AS count");
        $builder2->groupBy('HOUR(created_date)');
        $builder2->orderBy('hour', 'ASC');
        $timeQuery = $builder2->get()->getResultArray();

        $hours = array_column($timeQuery, 'hour');
        $hourCounts = array_column($timeQuery, 'count');

        // Pass data to view
        $data = [
            'totalRevenue' => $totalRevenue,
            'totalOrders'  => $totalOrders,
            'months'       => $months,
            'revenues'     => $revenues,
            'hours'        => $hours,
            'hourCounts'   => $hourCounts,
        ];

        return view('admin/report', $data);
    }

    public function getRevenueData()
    {
        $service = $this->request->getGet('service');
        $timeframe = $this->request->getGet('timeframe');

        $db = \Config\Database::connect();
        $builder = $db->table('Orders');

        if ($service !== 'all') {
            $builder->where('service_type', $service);
        }

        if ($timeframe === 'day') {
            $builder->select('DATE(created_date) as label, SUM(total_amount) as total');
            $builder->groupBy('DATE(created_date)');
            $builder->orderBy('DATE(created_date)', 'ASC');
        } elseif ($timeframe === 'week') {
            $builder->select('YEARWEEK(created_date, 1) as label, SUM(total_amount) as total');
            $builder->groupBy('YEARWEEK(created_date, 1)');
            $builder->orderBy('YEARWEEK(created_date, 1)', 'ASC');
        } else { // month
            $builder->select('YEAR(created_date) as y, MONTH(created_date) as label, SUM(total_amount) as total');
            $builder->groupBy(['YEAR(created_date)', 'MONTH(created_date)']);
            $builder->orderBy('YEAR(created_date)', 'ASC');
            $builder->orderBy('MONTH(created_date)', 'ASC');
        }

        $results = $builder->get()->getResultArray();

        $labels = [];
        $values = [];

        foreach ($results as $row) {
            if ($timeframe === 'day') {
                $labels[] = date('M d', strtotime($row['label']));
            } elseif ($timeframe === 'week') {
                $year = substr($row['label'], 0, 4);
                $week = substr($row['label'], 4);
                $labels[] = 'Week ' . (int)$week . ' (' . $year . ')';
            } else {
                $labels[] = date('M', mktime(0, 0, 0, $row['label'], 10)) . ' ' . $row['y'];
            }
            $values[] = (float) $row['total'];
        }

        return $this->response->setJSON([
            'labels' => $labels,
            'values' => $values
        ]);
    }

    public function order()
    {
        // Fetch orders with user information
        $db = \Config\Database::connect();
        $orders = $db->table('Orders')
            ->select('Orders.*, Users.first_name, Users.last_name, Users.email, Users.phone')
            ->join('Users', 'Users.user_id = Orders.user_id', 'left')
            ->orderBy('Orders.created_date', 'DESC')
            ->get()
            ->getResultArray();

        return view('admin/order', ['orders' => $orders]);
    }

    public function change_status($order_id)
    {
        $orderModel = new Order_model();
        $session = session();
        $userId = $session->get('user_id');

        $order = $orderModel->find($order_id);

        if ($order) {
            // Cycle through status: Pending → Confirmed → In_Storage → Out-for-Delivery → Completed → Pending
            $statusCycle = ['Pending', 'Confirmed', 'In_Storage', 'Out-for-Delivery', 'Completed'];
            $currentIndex = array_search($order['order_status'], $statusCycle);
            $newStatus = $statusCycle[($currentIndex + 1) % 5];

            $orderModel->update($order_id, ['order_status' => $newStatus]);

            session()->setFlashdata('success', 'Order status updated successfully.');
        } else {
            session()->setFlashdata('error', 'Order not found.');
        }

        return redirect()->to(base_url('/order'));
    }

    public function user()
    {
        // Fetch admin staff members (not customers)
        $db = \Config\Database::connect();
        $users = $db->table('Admins')
            ->orderBy('created_date', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'users' => $users
        ];

        return view('admin/users/staff', $data);
    }

    public function create_user()
    {
        $userModel = new User_model();

        if ($this->request->getMethod() === 'POST') {
            $data = [
                'role'          => $this->request->getPost('role'),
                'username'      => $this->request->getPost('username'),
                'email'      => $this->request->getPost('email'),
                'password'      => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'created_date'  => date('Y-m-d H:i:s'),
            ];

            $userModel->insert($data);
            return redirect()->to(base_url('admin/staff'))->with('success', 'Staff created successfully!');
        }

        return view('admin/users/create_user');
    }

    public function getDetails($order_id)
    {
        $orderModel = new Order_model();
        $order = $orderModel->getOrderWithUserById($order_id);

        if ($order) {
            return $this->response->setJSON([
                'success' => true,
                'order' => $order
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Order not found.'
            ]);
        }
    }

    public function save_note()
    {
        $orderId = $this->request->getPost('order_id');
        $note = $this->request->getPost('note');

        $orderModel = new Order_model();
        $orderModel->update($orderId, ['special_note' => $note, 'special' => 1]);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function exportRevenue()
    {
    $service   = $this->request->getGet('service') ?? 'all';
    $timeframe = $this->request->getGet('timeframe') ?? 'month';

    $db = \Config\Database::connect();
    $builder = $db->table('Orders');
    $builder->join('Users', 'Users.user_id = Orders.user_id', 'left');

    if ($service !== 'all') {
        $builder->where('Orders.service_type', $service);
    }

    // match the chart filters so the CSV mirrors what the user sees
    if ($timeframe === 'day') {
        $builder->where('Orders.created_date >=', date('Y-m-d 00:00:00', strtotime('-30 days')));
    } elseif ($timeframe === 'week') {
        $builder->where('Orders.created_date >=', date('Y-m-d 00:00:00', strtotime('-12 weeks')));
    } else {
        $builder->where('Orders.created_date >=', date('Y-m-01', strtotime('-11 months')));
    }

    $orders = $builder
        ->select([
            'Orders.order_id', 'Orders.service_type', 'Users.first_name', 'Users.last_name',
            'Users.email', 'Users.phone', 'Orders.total_amount', 'Orders.order_status', 'Orders.created_date'
        ])
        ->orderBy('Orders.created_date', 'ASC')
        ->get()
        ->getResultArray();

    $handle = fopen('php://temp', 'w');
    fputcsv($handle, ['Order ID', 'Service Type', 'Customer', 'Email', 'Phone', 'Amount (RM)', 'Status', 'Placed On']);

    foreach ($orders as $order) {
        fputcsv($handle, [
            $order['order_id'],
            $order['service_type'],
            trim($order['first_name'] . ' ' . $order['last_name']),
            $order['email'],
            $order['phone'],
            number_format((float) $order['total_amount'], 2, '.', ''),
            $order['order_status'],
            date('Y-m-d H:i:s', strtotime($order['created_date'])),
        ]);
    }

    rewind($handle);
    $csv = stream_get_contents($handle);
    fclose($handle);

    return $this->response
        ->setHeader('Content-Type', 'text/csv')
        ->setHeader('Content-Disposition', 'attachment; filename="revenue_' . date('Ymd_His') . '.csv"')
        ->setBody($csv);
    }

    public function locations()
    {
        $db = \Config\Database::connect();

        // Fetch all locations with their details
        $locations = $db->table('Locations')
            ->select('location_id, name as location_name, category, address, city, state, total_capacity, current_occupancy')
            ->orderBy('location_id', 'ASC')
            ->get()
            ->getResultArray();

        $data = [
            'locations' => $locations
        ];

        return view('admin/locations/index', $data);
    }

    public function partners()
    {
        $db = \Config\Database::connect();

        // Fetch all partners with their details
        $partners = $db->table('Partners')
            ->select('partner_id, name as partner_name, type, contact_person, contact_email, contact_phone, commission_rate, is_active, created_date')
            ->orderBy('partner_id', 'ASC')
            ->get()
            ->getResultArray();

        $data = [
            'partners' => $partners
        ];

        return view('admin/partners/index', $data);
    }
}
