<?php
namespace App\Models;

use CodeIgniter\Model;

class Seances extends Model
{
    protected $table = 'seances';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['emploi_du_temps_id','date_seance','heure_debut','heure_fin','a_eu_lieu','created_at'];
}
