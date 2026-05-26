<?php
namespace App\Models;

use CodeIgniter\Model;

class ProfilProfesseurs extends Model
{
    protected $table = 'profils_professeurs';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['user_id','matricule','nom','prenom','date_naissance','sexe','photo_url','telephone','adresse','specialite','type_contrat','date_debut_contrat','date_fin_contrat','is_archived','created_at','updated_at','id_contrat','id_matiere'];
}
