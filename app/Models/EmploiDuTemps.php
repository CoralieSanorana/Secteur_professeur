<?php
namespace App\Models;

use CodeIgniter\Model;

class EmploiDuTemps extends Model
{
    protected $table = 'emploi_du_temps';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['affectation_id','salle_id','jour_semaine','heure_debut','heure_fin','date_debut_validite','date_fin_validite','created_at'];
}
