<?php
namespace App\Models;

use CodeIgniter\Model;

class SupportsCours extends Model
{
    protected $table = 'supports_cours';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['affectation_id','type_fichier_id','titre','description','fichier_url','type_contenu','date_limite','accepte_retard','is_archived','cree_par','created_at','updated_at'];
}
