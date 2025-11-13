<?php

namespace App\Controllers;

use App\Models\User_model;

class Login extends BaseController
{
    public function index()
    {
        return view('admin/login');
    }

    public function submit()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // First check Admins table for staff login
        $db = \Config\Database::connect();
        $adminData = $db->table('Admins')
            ->where('email', $email)
            ->get()
            ->getRowArray();

        if ($adminData && password_verify($password, $adminData['password'])) {
            $session = session();
            $session->set([
                'user_id'   => $adminData['staff_id'],
                'username'  => $adminData['staff_name'],
                'email'     => $adminData['email'],
                'access'    => 1,
                'role'      => $adminData['role'] === 'Superadmin' ? '0' : '1'
            ]);

            return redirect()->to(base_url('/admin'));
        }

        // If not admin, check Users table (for future customer portal)
        $user = new User_model();
        $userData = $user->where('email', $email)->first();

        if ($userData && isset($userData['password']) && password_verify($password, $userData['password'])) {
            $session = session();
            $session->set([
                'user_id'  => $userData['user_id'],
                'username' => $userData['first_name'] . ' ' . $userData['last_name'],
                'email'    => $userData['email'],
                'access'   => 1,
                'role'     => $userData['role'] ?? '2' // Regular user
            ]);

            return redirect()->to(base_url('/admin'));
        }

        return redirect()->back()->with('error', 'Incorrect email or password');
    }


    public function logout()
    {
        $session = \Config\Services::session();
        $session->destroy();
        return redirect()->to(base_url('/login'));
    }
}
