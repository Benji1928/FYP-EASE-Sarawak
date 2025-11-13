<?php

namespace App\Controllers;

class AdminPromo extends BaseAdminController
{
    protected $promoModel;

    public function __construct()
    {
        $this->promoModel = new \App\Models\Promo_model();
    }

    // List all promo codes
    public function index()
    {
        $data = [
            'title' => 'Manage Promo Codes',
            'promos' => $this->promoModel->findAll(),
        ];

        return view('admin/promo/index', $data);
    }

    // Create promo form
    public function create()
    {
        $data = ['title' => 'Create Promo Code'];
        return view('admin/promo/create', $data);
    }

    // Store new promo
    public function store()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'promo_code' => 'required|alpha_numeric|max_length[255]|is_unique[Promo.promo_code]',
            'discount_type' => 'required|in_list[Flat,Percent]',
            'discount_value' => 'required|decimal',
            'start_date' => 'required|valid_date',
            'end_date' => 'required|valid_date',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'promo_code' => strtoupper($this->request->getPost('promo_code')),
            'discount_type' => $this->request->getPost('discount_type'),
            'discount_value' => $this->request->getPost('discount_value'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
            'usage_limit' => $this->request->getPost('usage_limit') ?: null,
            'is_active' => $this->request->getPost('is_active') ? true : false,
            'created_by' => $this->session->get('admin_id'),
        ];

        if ($this->promoModel->insert($data)) {
            return $this->successMessage('Promo code created successfully', 'admin/promo');
        }

        return $this->errorMessage('Failed to create promo code', 'admin/promo/create');
    }

    // Edit promo form
    public function edit($code)
    {
        $promo = $this->promoModel->find($code);

        if (!$promo) {
            return $this->errorMessage('Promo code not found', 'admin/promo');
        }

        $data = [
            'title' => 'Edit Promo Code',
            'promo' => $promo,
        ];

        return view('admin/promo/edit', $data);
    }

    // Update promo
    public function update($code)
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'discount_value' => 'required|decimal',
            'start_date' => 'required|valid_date',
            'end_date' => 'required|valid_date',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'discount_value' => $this->request->getPost('discount_value'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
            'usage_limit' => $this->request->getPost('usage_limit') ?: null,
            'is_active' => $this->request->getPost('is_active') ? true : false,
        ];

        if ($this->promoModel->update($code, $data)) {
            return $this->successMessage('Promo code updated successfully', 'admin/promo');
        }

        return $this->errorMessage('Failed to update promo code', 'admin/promo/edit/' . $code);
    }

    // Delete promo
    public function delete($code)
    {
        if (!$this->hasRole('Superadmin')) {
            return $this->errorMessage('Unauthorized action', 'admin/promo');
        }

        if ($this->promoModel->delete($code)) {
            return $this->successMessage('Promo code deleted successfully', 'admin/promo');
        }

        return $this->errorMessage('Failed to delete promo code', 'admin/promo');
    }
}
