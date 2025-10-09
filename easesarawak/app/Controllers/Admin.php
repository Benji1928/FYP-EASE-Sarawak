<?php

namespace App\Controllers;

use App\Models\Order_model;
use App\Models\User_model;

class Admin extends BaseController
{
    public function index(): string
    {
        return view('admin/dashboard');
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

    public function order()
    {
        $order_model = new Order_model();
        $orders = $order_model->where('is_deleted',0)->findAll();
        // print_r($order);exit;
        return view('admin/order', ['orders' => $orders]);
    }

    public function change_status($order_id)
    {
        $orderModel = new \App\Models\Order_model();
        $order = $orderModel->find($order_id);

        if ($order) {
            // Cycle through status: 0 → 1 → 2 → 0
            $newStatus = ($order['status'] + 1) % 3;

            $orderModel->update($order_id, ['status' => $newStatus]);
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
                'password'      => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'created_date'  => date('Y-m-d H:i:s'),
            ];
            
            $userModel->insert($data);
            return redirect()->to(base_url('/user'))->with('success', 'User created successfully!');
        }

        return view('admin/create_user');
    }
}
