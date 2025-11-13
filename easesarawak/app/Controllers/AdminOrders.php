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

        $orders = $db->table('Orders o')
            ->select('o.*, u.first_name, u.last_name, u.email, p.name as partner_name')
            ->join('Users u', 'u.user_id = o.user_id')
            ->join('Partners p', 'p.partner_id = o.partner_id', 'left')
            ->orderBy('o.created_date', 'DESC')
            ->paginate(20);

        $data = [
            'title' => 'Manage Orders',
            'orders' => $orders,
            'pager' => $db->table('Orders')->pager,
        ];

        return view('admin/orders/index', $data);
    }

    // View order details
    public function view($id)
    {
        $db = \Config\Database::connect();

        $order = $db->table('Orders o')
            ->select('o.*, u.*, p.name as partner_name,
                      pl.name as pickup_location, dl.name as dropoff_location,
                      pm.amount as payment_amount, pm.status as payment_status, pm.method as payment_method')
            ->join('Users u', 'u.user_id = o.user_id')
            ->join('Partners p', 'p.partner_id = o.partner_id', 'left')
            ->join('Locations pl', 'pl.location_id = o.pickup_location_id', 'left')
            ->join('Locations dl', 'dl.location_id = o.dropoff_location_id')
            ->join('Payments pm', 'pm.payment_id = o.payment_id', 'left')
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
            ->select('d.*, a.staff_name as driver_name, v.license_plate')
            ->join('Admins a', 'a.staff_id = d.driver_id', 'left')
            ->join('Vehicles v', 'v.vehicle_id = d.vehicle_id', 'left')
            ->where('d.order_id', $id)
            ->get()
            ->getRow();

        // Get storage tracking
        $storageTracking = $db->table('Storage_Tracking st')
            ->select('st.*, l.name as location_name')
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
            return $this->errorMessage('Invalid status', 'admin/orders/view/' . $id);
        }

        $data = ['order_status' => $newStatus];

        if ($newStatus === 'Cancelled') {
            $data['is_cancelled'] = 1;
            $data['cancellation_reason'] = $this->request->getPost('cancellation_reason');
            $data['cancellation_time'] = date('Y-m-d H:i:s');
        }

        if ($this->orderModel->update($id, $data)) {
            return $this->successMessage('Order status updated successfully', 'admin/orders/view/' . $id);
        }

        return $this->errorMessage('Failed to update order status', 'admin/orders/view/' . $id);
    }
}
