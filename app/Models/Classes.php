<?php
namespace App\Models;

use CodeIgniter\Model;

class Classes extends Model
{
    protected $table = 'classes';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['niveau_id','annee_scolaire_id','nom','capacite_max','created_at'];
}
