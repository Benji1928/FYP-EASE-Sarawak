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

        $user = new User_model();
        $userData = $user->where([
            'email' => $email,
            'is_deleted' => 0
        ])->first();

        if ($userData && password_verify($password, $userData['password'])) {
            $session = session();
            $session->set([
                'user_id' => $userData['user_id'],
                'username' => $userData['username'],
                'email'    => $userData['email'],
                'access'   => 1,
                'role'     => $userData['role']
            ]);

            return redirect()->to(base_url('/admin'));
        } else {
            return redirect()->back()->with('error', 'Incorrect username or password');
        }
    }


    public function logout()
    {
        $session = \Config\Services::session();
        $session->destroy();
        return redirect()->to(base_url('/login'));
    }
}
