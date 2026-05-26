<?php
namespace App\Models;

use CodeIgniter\Model;

class Salles extends Model
{
    protected $table = 'salles';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['etablissement_id','nom','capacite','type','is_active','created_at'];
}
