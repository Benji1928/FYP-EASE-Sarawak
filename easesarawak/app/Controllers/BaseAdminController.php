<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class BaseAdminController extends Controller
{
    protected $session;
    protected $helpers = ['url', 'form'];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->session = \Config\Services::session();

        // Check if user is logged in as admin (using same auth as Admin controller)
        $access = $this->session->get('access');
        $role = $this->session->get('role');

        if (empty($access) || ($role !== '1' && $role !== '0')) {
            // Redirect to login if not authenticated
            if (!($request instanceof CLIRequest)) {
                header('Location: ' . base_url('login'));
                exit();
            }
        }
    }

    /**
     * Check if user has specific role
     */
    protected function hasRole($role)
    {
        $adminRole = $this->session->get('admin_role');
        if ($role === 'Superadmin') {
            return $adminRole === 'Superadmin';
        }
        return in_array($adminRole, [$role, 'Superadmin']);
    }

    /**
     * Return JSON response
     */
    protected function jsonResponse($data, $status = 200)
    {
        return $this->response->setJSON($data)->setStatusCode($status);
    }

    /**
     * Return success message
     */
    protected function successMessage($message, $redirect = null)
    {
        $this->session->setFlashdata('success', $message);
        if ($redirect) {
            return redirect()->to($redirect);
        }
    }

    /**
     * Return error message
     */
    protected function errorMessage($message, $redirect = null)
    {
        $this->session->setFlashdata('error', $message);
        if ($redirect) {
            return redirect()->to($redirect);
        }
    }
}
