<?php
namespace App\Models;

use CodeIgniter\Model;

class Periodes extends Model
{
    protected $table = 'periodes';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['annee_scolaire_id','libelle','type','ordre','date_debut','date_fin','date_publication_notes','est_cloturee'];
}
