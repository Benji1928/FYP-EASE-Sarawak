<?php

namespace App\Models;

use CodeIgniter\Model;

class User_model extends Model
{
    protected $table            = 'user';
    protected $primaryKey       = 'user_id';
    protected $allowedFields    = ['role', 'username',  'password', 'email', 'is_deleted', 'created_date', 'modified_date'];
}
