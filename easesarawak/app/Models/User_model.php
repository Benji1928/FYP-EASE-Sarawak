<?php
namespace App\Models;
use CodeIgniter\Model;

class User_model extends Model
{
    protected $table = 'Users';  // Changed from 'user'
    protected $primaryKey = 'user_id';
    protected $allowedFields = [
        'first_name', 'last_name', 'email', 'phone', 'social', 'social_num',
        'nationality', 'customer_type', 'customer_segment', 'source_of_booking',
        'how_heard_about_us', 'total_bookings', 'lifetime_value',
        'customer_acquisition_cost', 'is_active'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_date';
    protected $updatedField = 'updated_date';
}