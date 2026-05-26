<?php
namespace App\Models;

use CodeIgniter\Model;

class Users extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['email','password_hash','is_active','last_login','created_at','updated_at'];
}
