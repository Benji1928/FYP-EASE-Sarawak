<?php

namespace App\Controllers;

class AdminLocations extends BaseAdminController
{
    protected $locationModel;

    public function __construct()
    {
        $this->locationModel = new \App\Models\Location_model();
    }

    // List all locations
    public function index()
    {
        // Use query builder to get arrays and map location_name to name
        $db = \Config\Database::connect();
        $locations = $db->table('Locations')
            ->get()
            ->getResultArray();
        
        // Map location_name to name for views
        foreach ($locations as &$location) {
            if (isset($location['location_name'])) {
                $location['name'] = $location['location_name'];
            }
        }
        
        $data = [
            'title' => 'Manage Locations',
            'locations' => $locations,
        ];

        return view('admin/management/locations', $data);
    }

    // Create location form
    public function create()
    {
        $data = ['title' => 'Add New Location'];
        return view('admin/locations/create', $data);
    }

    // Store new location
    public function store()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[255]',
            'category' => 'required|in_list[Airport,Hotel,Shopping Mall,Hub,Partner_Location,Other]',
            'total_capacity' => 'permit_empty|integer',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'location_name' => $this->request->getPost('name'),
            'category' => $this->request->getPost('category'),
            'address' => $this->request->getPost('address'),
            'total_capacity' => $this->request->getPost('total_capacity'),
            'is_active' => $this->request->getPost('is_active') ? true : false,
        ];

        if ($this->locationModel->insert($data)) {
            return $this->successMessage('Location created successfully', 'admin/locations');
        }

        return $this->errorMessage('Failed to create location', 'admin/locations/create');
    }

    // Edit location form
    public function edit($id)
    {
        // Use query builder to get array directly
        $db = \Config\Database::connect();
        $location = $db->table('Locations')
            ->where('location_id', $id)
            ->get()
            ->getRowArray();

        if (!$location) {
            return $this->errorMessage('Location not found', 'admin/locations');
        }

        // Map location_name to name for views
        if (isset($location['location_name'])) {
            $location['name'] = $location['location_name'];
        }

        $data = [
            'title' => 'Edit Location',
            'location' => $location,
        ];

        return view('admin/locations/edit', $data);
    }

    // Update location
    public function update($id)
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[255]',
            'category' => 'required',
            'total_capacity' => 'permit_empty|integer',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Get location data for the view when validation fails
            $db = \Config\Database::connect();
            $location = $db->table('Locations')
                ->where('location_id', $id)
                ->get()
                ->getRowArray();
            
            // Map location_name to name for views
            if (isset($location['location_name'])) {
                $location['name'] = $location['location_name'];
            }
            
            $data = [
                'title' => 'Edit Location',
                'location' => $location,
            ];
            
            return view('admin/locations/edit', $data)->with('errors', $validation->getErrors());
        }

        $data = [
            'location_name' => $this->request->getPost('name'),
            'category' => $this->request->getPost('category'),
            'address' => $this->request->getPost('address'),
            'total_capacity' => $this->request->getPost('total_capacity'),
            'is_active' => $this->request->getPost('is_active') ? true : false,
        ];

        if ($this->locationModel->update($id, $data)) {
            return $this->successMessage('Location updated successfully', 'admin/locations');
        }

        return $this->errorMessage('Failed to update location', 'admin/locations/edit/' . $id);
    }

    // Delete location
    public function delete($id)
    {
        if (!$this->hasRole('Superadmin')) {
            return $this->errorMessage('Unauthorized action', 'admin/locations');
        }

        if ($this->locationModel->delete($id)) {
            return $this->successMessage('Location deleted successfully', 'admin/locations');
        }

        return $this->errorMessage('Failed to delete location', 'admin/locations');
    }

    // View location storage status
    public function storage($id)
    {
        // Use query builder to get array directly
        $db = \Config\Database::connect();
        $location = $db->table('Locations')
            ->where('location_id', $id)
            ->get()
            ->getRowArray();

        if (!$location) {
            return $this->errorMessage('Location not found', 'admin/locations');
        }

        // Map location_name to name for views
        if (isset($location['location_name'])) {
            $location['name'] = $location['location_name'];
        }

        // Get current storage items at this location
        $storageItems = $db->table('Storage_Tracking st')
            ->select('st.*, o.order_id, u.first_name, u.last_name, li.size')
            ->join('Orders o', 'o.order_id = st.order_id')
            ->join('Users u', 'u.user_id = o.user_id')
            ->join('LuggageItems li', 'li.order_id = o.order_id', 'left')
            ->where('st.location_id', $id)
            ->where('st.storage_end_time IS NULL')
            ->get()
            ->getResult();

        $data = [
            'title' => 'Location Storage Status',
            'location' => $location,
            'storage_items' => $storageItems,
        ];

        return view('admin/locations/storage', $data);
    }
}
