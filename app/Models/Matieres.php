<?php
namespace App\Models;

use CodeIgniter\Model;

class Matieres extends Model
{
    protected $table = 'matieres';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['etablissement_id','nom','code','created_at'];
}
