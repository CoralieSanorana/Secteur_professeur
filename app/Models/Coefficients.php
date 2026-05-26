<?php
namespace App\Models;

use CodeIgniter\Model;

class Coefficients extends Model
{
    protected $table = 'coefficients';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['matiere_id','niveau_id','valeur'];
}
