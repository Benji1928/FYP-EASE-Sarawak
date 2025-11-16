<?php
namespace App\Models;
use CodeIgniter\Model;

class Location_model extends Model
{
    protected $table = 'Locations';
    protected $primaryKey = 'location_id';
    protected $allowedFields = [
        'location_name', 'category', 'address', 'total_capacity',
        'current_occupancy', 'is_active'
    ];
    protected $useTimestamps = false; // No updated_date column in database, only created_date
    protected $createdField = 'created_date';
}