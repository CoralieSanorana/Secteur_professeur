<?php
namespace App\Models;

use CodeIgniter\Model;

class Absences extends Model
{
    protected $table = 'absences';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['seance_id','etudiant_id','type','motif','justificatif_url','saisi_par','valide_par','date_validation','created_at','updated_at'];
}
