<?php

namespace App\Controllers;

class AdminUsers extends BaseAdminController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new \App\Models\User_model();
    }

    // List all users
    public function index()
    {
        $data = [
            'title' => 'Manage Users',
            'users' => $this->userModel->paginate(20),
            'pager' => $this->userModel->pager,
        ];

        return view('admin/users/users', $data);
    }

    // View user details
    public function view($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return $this->errorMessage('User not found', 'users');
        }

        $db = \Config\Database::connect();

        // Get user's orders
        $orders = $db->table('Orders')
            ->where('user_id', $id)
            ->orderBy('created_date', 'DESC')
            ->get()
            ->getResult();

        // Get user's reviews
        $reviews = $db->table('Reviews')
            ->where('user_id', $id)
            ->orderBy('created_date', 'DESC')
            ->get()
            ->getResult();

        $data = [
            'title' => 'User Details',
            'user' => $user,
            'orders' => $orders,
            'reviews' => $reviews,
        ];

        return view('admin/users/view', $data);
    }

    // Search/filter users
    public function search()
    {
        $searchTerm = $this->request->getGet('q');
        $customerType = $this->request->getGet('type');
        $nationality = $this->request->getGet('nationality');

        $builder = $this->userModel;

        if ($searchTerm) {
            $builder = $builder->like('first_name', $searchTerm)
                ->orLike('last_name', $searchTerm)
                ->orLike('email', $searchTerm);
        }

        if ($customerType) {
            $builder = $builder->where('customer_type', $customerType);
        }

        if ($nationality) {
            $builder = $builder->where('nationality', $nationality);
        }

        $data = [
            'title' => 'Search Users',
            'users' => $builder->paginate(20),
            'pager' => $builder->pager,
        ];

        return view('admin/users/index', $data);
    }
}
