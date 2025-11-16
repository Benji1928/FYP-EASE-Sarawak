<?php

namespace App\Controllers;

class AdminOrders extends BaseAdminController
{
    protected $orderModel;

    public function __construct()
    {
        $this->orderModel = new \App\Models\Order_model();
    }

    // List all orders
    public function index()
    {
        $db = \Config\Database::connect();

        // Get total count for pagination
        $builder = $db->table('Orders o')
            ->join('Users u', 'u.user_id = o.user_id')
            ->join('Partners p', 'p.partner_id = o.partner_id', 'left');

        $total = $builder->countAllResults(false); // false keeps the builder state

        // Get paginated results
        $perPage = 20;
        $page = $this->request->getVar('page') ?? 1;

        $orders = $builder
            ->select('o.*, u.first_name, u.last_name, u.email, p.partner_name as partner_name')
            ->orderBy('o.created_date', 'DESC')
            ->limit($perPage, ($page - 1) * $perPage)
            ->get()
            ->getResultArray();

        // Create pager
        $pager = \Config\Services::pager();
        $pager->store('default', $page, $perPage, $total);

        $data = [
            'title' => 'Manage Orders',
            'orders' => $orders,
            'pager' => $pager,
        ];

        return view('admin/orders/order', $data);
    }

    // View order details
    public function view($id)
    {
        $db = \Config\Database::connect();

        $order = $db->table('Orders o')
            ->select('o.*, u.*, p.partner_name,
                      pl.location_name as pickup_location, dl.location_name as dropoff_location,
                      pm.amount as payment_amount, pm.status as payment_status, pm.method as payment_method,
                      a.staff_name as modified_by_name')
            ->join('Users u', 'u.user_id = o.user_id')
            ->join('Partners p', 'p.partner_id = o.partner_id', 'left')
            ->join('Locations pl', 'pl.location_id = o.pickup_location_id', 'left')
            ->join('Locations dl', 'dl.location_id = o.dropoff_location_id')
            ->join('Payments pm', 'pm.payment_id = o.payment_id', 'left')
            ->join('Admins a', 'a.staff_id = o.modified_by', 'left')
            ->where('o.order_id', $id)
            ->get()
            ->getRow();

        if (!$order) {
            return $this->errorMessage('Order not found', 'admin/orders');
        }

        // Get luggage items
        $luggageItems = $db->table('LuggageItems')
            ->where('order_id', $id)
            ->get()
            ->getResult();

        // Get delivery info
        $delivery = $db->table('Delivery d')
            ->select('d.*, a.staff_name as driver_name')
            ->join('Admins a', 'a.staff_id = d.driver_id', 'left')
            ->where('d.order_id', $id)
            ->get()
            ->getRow();

        // Get storage tracking
        $storageTracking = $db->table('Storage_Tracking st')
            ->select('st.*, l.location_name')
            ->join('Locations l', 'l.location_id = st.location_id', 'left')
            ->where('st.order_id', $id)
            ->get()
            ->getRow();

        $data = [
            'title' => 'Order Details',
            'order' => $order,
            'luggage_items' => $luggageItems,
            'delivery' => $delivery,
            'storage_tracking' => $storageTracking,
        ];

        return view('admin/orders/view', $data);
    }

    // Update order status
    public function updateStatus($id)
    {
        $newStatus = $this->request->getPost('order_status');

        $validStatuses = ['Pending', 'Confirmed', 'In_Storage', 'Out-for-Delivery', 'Completed', 'Cancelled'];

        if (!in_array($newStatus, $validStatuses)) {
            if ($this->request->isAJAX()) {
                return $this->jsonResponse(['success' => false, 'message' => 'Invalid status'], 400);
            }
            return $this->errorMessage('Invalid status', 'admin/orders');
        }

        $data = ['order_status' => $newStatus];

        if ($newStatus === 'Cancelled') {
            $data['is_cancelled'] = 1;
            $data['cancellation_reason'] = $this->request->getPost('cancellation_reason');
            $data['cancellation_time'] = date('Y-m-d H:i:s');
        }

        if ($this->orderModel->update($id, $data)) {
            if ($this->request->isAJAX()) {
                return $this->jsonResponse(['success' => true, 'message' => 'Order status updated successfully']);
            }
            return $this->successMessage('Order status updated successfully', 'admin/orders');
        }

        if ($this->request->isAJAX()) {
            return $this->jsonResponse(['success' => false, 'message' => 'Failed to update order status'], 500);
        }
        return $this->errorMessage('Failed to update order status', 'admin/orders');
    }
}
