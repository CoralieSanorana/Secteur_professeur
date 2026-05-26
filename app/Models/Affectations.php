<?php
namespace App\Models;

use CodeIgniter\Model;

class Affectations extends Model
{
    protected $table = 'affectations_enseignement';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['professeur_id','matiere_id','classe_id','annee_scolaire_id','heures_hebdo','created_at'];
}
