<?php
namespace App\Models;

use CodeIgniter\Model;

class TypesFichiers extends Model
{
    protected $table = 'types_fichiers';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['libelle','created_at'];
}
