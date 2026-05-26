<?php
namespace App\Models;

use CodeIgniter\Model;

class Notes extends Model
{
    protected $table = 'notes';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['etudiant_id','affectation_id','periode_id','type_evaluation','valeur','sur','commentaire','saisi_par','date_saisie','est_valide','ancienne_valeur','corrige_par','date_correction','motif_correction','created_at','updated_at'];
}
