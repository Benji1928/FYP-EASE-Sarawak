<?php

namespace App\Controllers;

class AdminPartners extends BaseAdminController
{
    protected $partnerModel;

    public function __construct()
    {
        $this->partnerModel = new \App\Models\Partner_model();
    }

    // List all partners
    public function index()
    {
        $data = [
            'title' => 'Manage Partners',
            'partners' => $this->partnerModel->paginate(20),
            'pager' => $this->partnerModel->pager,
        ];

        return view('admin/management/partners', $data);
    }

    // Create partner form
    public function create()
    {
        $data = ['title' => 'Add New Partner'];
        return view('admin/partners/create', $data);
    }

    // Store new partner
    public function store()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[255]',
            'type' => 'required|in_list[Hotel,Airbnb,TourAgency,Event,Airline,Travel_Agency,Other]',
            'commission_rate' => 'required|decimal',
            'contact_email' => 'permit_empty|valid_email',
            'contact_phone' => 'permit_empty|max_length[20]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'type' => $this->request->getPost('type'),
            'commission_rate' => $this->request->getPost('commission_rate'),
            'contact_person' => $this->request->getPost('contact_person'),
            'contact_email' => $this->request->getPost('contact_email'),
            'contact_phone' => $this->request->getPost('contact_phone'),
            'payment_terms' => $this->request->getPost('payment_terms'),
            'contract_start_date' => $this->request->getPost('contract_start_date'),
            'contract_end_date' => $this->request->getPost('contract_end_date'),
            'address' => $this->request->getPost('address'),
            'is_active' => $this->request->getPost('is_active') ? true : false,
        ];

        if ($this->partnerModel->insert($data)) {
            return $this->successMessage('Partner created successfully', 'admin/partners');
        }

        return $this->errorMessage('Failed to create partner', 'admin/partners/create');
    }

    // Edit partner form
    public function edit($id)
    {
        // Use query builder to get array directly
        $db = \Config\Database::connect();
        $partner = $db->table('Partners')
            ->where('partner_id', $id)
            ->get()
            ->getRowArray();

        if (!$partner) {
            return $this->errorMessage('Partner not found', 'admin/partners');
        }

        $data = [
            'title' => 'Edit Partner',
            'partner' => $partner,
        ];

        return view('admin/partners/edit', $data);
    }

    // Update partner
    public function update($id)
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[255]',
            'type' => 'required',
            'commission_rate' => 'required|decimal',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Get partner data for the view when validation fails
            $db = \Config\Database::connect();
            $partner = $db->table('Partners')
                ->where('partner_id', $id)
                ->get()
                ->getRowArray();
            
            $data = [
                'title' => 'Edit Partner',
                'partner' => $partner,
            ];
            
            return view('admin/partners/edit', $data)->with('errors', $validation->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'type' => $this->request->getPost('type'),
            'commission_rate' => $this->request->getPost('commission_rate'),
            'contact_person' => $this->request->getPost('contact_person'),
            'contact_email' => $this->request->getPost('contact_email'),
            'contact_phone' => $this->request->getPost('contact_phone'),
            'payment_terms' => $this->request->getPost('payment_terms'),
            'contract_start_date' => $this->request->getPost('contract_start_date'),
            'contract_end_date' => $this->request->getPost('contract_end_date'),
            'address' => $this->request->getPost('address'),
            'is_active' => $this->request->getPost('is_active') ? true : false,
        ];

        if ($this->partnerModel->update($id, $data)) {
            return $this->successMessage('Partner updated successfully', 'admin/partners');
        }

        return $this->errorMessage('Failed to update partner', 'admin/partners/edit/' . $id);
    }

    // Delete partner
    public function delete($id)
    {
        if (!$this->hasRole('Superadmin')) {
            return $this->errorMessage('Unauthorized action', 'admin/partners');
        }

        if ($this->partnerModel->delete($id)) {
            return $this->successMessage('Partner deleted successfully', 'admin/partners');
        }

        return $this->errorMessage('Failed to delete partner', 'admin/partners');
    }

    // View partner performance
    public function performance($id)
    {
        $partner = $this->partnerModel->find($id);

        if (!$partner) {
            return $this->errorMessage('Partner not found', 'admin/partners');
        }

        $db = \Config\Database::connect();

        // Get partner performance data
        $performance = $db->table('Partner_Performance')
            ->where('partner_id', $id)
            ->orderBy('period_start', 'DESC')
            ->get()
            ->getResult();

        // Get partner orders
        $orders = $db->table('Orders')
            ->where('partner_id', $id)
            ->orderBy('created_date', 'DESC')
            ->limit(50)
            ->get()
            ->getResult();

        $data = [
            'title' => 'Partner Performance',
            'partner' => $partner,
            'performance' => $performance,
            'orders' => $orders,
        ];

        return view('admin/partners/performance', $data);
    }
}
