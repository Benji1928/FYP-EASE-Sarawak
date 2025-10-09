<?php

namespace App\Models;

use CodeIgniter\Model;

class Order_model extends Model
{
    protected $table            = 'order';
    protected $primaryKey       = 'order_id';
    protected $allowedFields    = ['service_type', 'first_name', 'last_name', 'id_num', 'email', 'phone',
    'social', '	social_num', '	upload', '	special', 'special_note', 'order_details_json', 'promo_code', 'status', 
    'amount', '	payment_method', 'is_deleted', 'created_date', 'modified_date'];
}