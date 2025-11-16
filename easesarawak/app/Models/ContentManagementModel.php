<?php
namespace App\Models;

use CodeIgniter\Model;

class ContentManagementModel extends Model
{
    protected $table      = 'content_management';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'content', 'created_at', 'updated_at', 'type', 'image', 'is_active'];
}