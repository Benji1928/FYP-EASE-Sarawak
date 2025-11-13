<?php
namespace App\Models;
use CodeIgniter\Model;

class Order_model extends Model
{
    protected $table = 'Orders'; 
    protected $primaryKey = 'order_id';
    protected $allowedFields = [
        'user_id', 'special', 'special_note', 'service_type', 'order_details_json',
        'dropoff_time', 'pickup_time', 'requested_delivery_time',
        'pickup_location_id', 'dropoff_location_id', 'pickup_location_type',
        'dropoff_location_type', 'status', 'order_status', 'promo_code', 'is_cancelled',
        'cancellation_reason', 'cancellation_time', 'base_price', 'insurance_fee',
        'delivery_fee', 'discount_amount', 'total_amount', 'number_of_bags',
        'has_oversized_bags', 'has_special_items', 'booking_channel',
        'booking_source', 'modified_by', 'payment_id', 'partner_id'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_date';
    protected $updatedField = 'updated_date';

    public function getOrderWithUserById($order_id)
    {
        return $this->db->table('Orders o')
            ->select('o.*, u.first_name, u.last_name, a.staff_name AS modified_by_name')
            ->join('Users u', 'u.user_id = o.user_id')
            ->join('Admins a', 'a.staff_id = o.modified_by', 'left')
            ->where('o.order_id', $order_id)
            ->get()
            ->getRowArray();
    }
}