<?php
namespace App\Models;

use CodeIgniter\Model;

class Moyennes extends Model
{
    protected $table = 'moyennes';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['etudiant_id','inscription_id','periode_id','matiere_id','valeur','rang','effectif_classe','calculated_at'];
}
