<?php
namespace App\Models;

use CodeIgniter\Model;

class Niveaux extends Model
{
    protected $table = 'niveaux';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['etablissement_id','libelle','ordre','created_at'];
}
