<?php
namespace App\Models;
use CodeIgniter\Model;

class Partner_model extends Model
{
    protected $table = 'Partners';
    protected $primaryKey = 'partner_id';
    protected $allowedFields = [
        'name', 'commission_rate', 'type', 'contact_person', 'contact_email',
        'contact_phone', 'payment_terms', 'contract_start_date', 'contract_end_date',
        'is_active', 'address'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_date';
    protected $updatedField = 'updated_date';
}
