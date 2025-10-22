<?php

namespace App\Controllers;

use App\Models\Order_model;
use App\Models\User_model;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Admin extends BaseController
{
    public $data = [];
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

        $order = $order_model->where('is_deleted', 0)->countAllResults();
        $user  = $user_model->where('is_deleted', 0)->countAllResults();
        $sales = $order_model
            ->selectSum('amount')
            ->where('is_deleted', 0)
            ->get()
            ->getRow()
            ->amount ?? 0;
        $totalOrders = $order_model
            ->where('is_deleted', 0)
            ->countAllResults();

        // Fetch all pending orders
        $pending_orders = $order_model
            ->where('status', 'pending')
            ->findAll();

        $data = [ 'order_count'    => $order,
                  'user_count'     => $user,
                  'sales'          => $sales,
                  'orders'         => $totalOrders,
                  'pending_orders' => $pending_orders
                ];

        return view('admin/dashboard', $data);
    }

    public function report()
    {
        $order_model = new Order_model();

        // Total Revenue (sum of all order amounts)
        $totalRevenue = $order_model
            ->selectSum('amount')
            ->where('is_deleted', 0)
            ->get()
            ->getRow()
            ->amount ?? 0;

        // Total Orders (count)
        $totalOrders = $order_model
            ->where('is_deleted', 0)
            ->countAllResults();

        // Revenue Breakdown (Last 6 Months)
        $db = \Config\Database::connect();
        $builder = $db->table('order');

        // select only aggregated or grouped expressions — no plain columns
        $builder->select("DATE_FORMAT(MIN(created_date), '%b %Y') AS month, SUM(amount) AS total");
        $builder->where('is_deleted', 0);
        $builder->where('created_date >=', date('Y-m-01', strtotime('-5 months')));
        $builder->groupBy("YEAR(created_date), MONTH(created_date)");
        $builder->orderBy("YEAR(created_date)", 'ASC');
        $builder->orderBy("MONTH(created_date)", 'ASC');

        $revenueQuery = $builder->get()->getResultArray();

        $months   = array_column($revenueQuery, 'month');
        $revenues = array_map('floatval', array_column($revenueQuery, 'total'));

        // Peak Booking Times (based on created_date hour)
        $builder2 = $db->table('order');
        $builder2->select("HOUR(created_date) AS hour, COUNT(order_id) AS count");
        $builder2->where('is_deleted', 0);
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
        $builder = $db->table('order');

        if ($service !== 'all') {
            $builder->where('service_type', $service);
        }

        if ($timeframe === 'day') {
            $builder->select('DATE(created_date) as label, SUM(amount) as total');
            $builder->groupBy('DATE(created_date)');
            $builder->orderBy('DATE(created_date)', 'ASC');
        } elseif ($timeframe === 'week') {
            $builder->select('YEARWEEK(created_date, 1) as label, SUM(amount) as total');
            $builder->groupBy('YEARWEEK(created_date, 1)');
            $builder->orderBy('YEARWEEK(created_date, 1)', 'ASC');
        } else { // month
            $builder->select('YEAR(created_date) as y, MONTH(created_date) as label, SUM(amount) as total');
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
        $order_model = new Order_model();
        $orders = $order_model->where('is_deleted', 0)->findAll();
        // print_r($orders);exit;
        return view('admin/order', ['orders' => $orders]);
    }

    public function change_status($order_id)
    {
        $orderModel = new Order_model();
        $session = session();
        $userId = $session->get('user_id');

        $order = $orderModel->find($order_id);

        if ($order) {
            // Cycle through status: 0 → 1 → 2 → 0
            $newStatus = ($order['status'] + 1) % 3;
            $orderModel->update($order_id, ['status' => $newStatus,
                    'modified_by' => $userId,
                    'modified_date' => date('Y-m-d H:i:s')]);

            session()->setFlashdata('success', 'Order status updated successfully.');
        } else {
            session()->setFlashdata('error', 'Order not found.');
        }

        return redirect()->to(base_url('/order'));
    }

    public function user()
    {
        $user_model = new User_model();
        $users = $user_model->where('is_deleted', 0)->findAll();

        $data = [
            'users' => $users
        ];

        return view('admin/user', $data);
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
            return redirect()->to(base_url('/user'))->with('success', 'User created successfully!');
        }

        return view('admin/create_user');
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
        $orderModel->update($orderId, ['comment' => $note]);

        return $this->response->setJSON(['status' => 'success']);
    }
}
