<?php
namespace App\Models;
use CodeIgniter\Model;

class Location_model extends Model
{
    protected $table = 'Locations';
    protected $primaryKey = 'location_id';
    protected $allowedFields = [
        'name', 'category', 'address', 'total_capacity',
        'current_occupancy', 'is_active'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_date';
}
?>s