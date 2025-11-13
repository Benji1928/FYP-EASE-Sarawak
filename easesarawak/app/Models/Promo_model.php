<?php
namespace App\Models;
use CodeIgniter\Model;

class Promo_model extends Model
{
    protected $table = 'Promo';
    protected $primaryKey = 'promo_code';
    protected $allowedFields = [
        'promo_code', 'discount_type', 'discount_value', 'start_date',
        'end_date', 'usage_limit', 'times_used', 'is_active', 'created_by'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_date';
}