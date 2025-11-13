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

        // Check if user is logged in as admin
        if (!$this->session->get('isAdminLoggedIn')) {
            // Redirect to admin login if not authenticated
            if (!($request instanceof CLIRequest) && !str_contains($request->getUri()->getPath(), 'admin/login')) {
                header('Location: ' . base_url('admin/login'));
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
