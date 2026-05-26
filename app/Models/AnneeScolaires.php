<?php
namespace App\Models;

use CodeIgniter\Model;

class AnneeScolaires extends Model
{
    protected $table = 'annees_scolaires';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['etablissement_id','libelle','date_debut','date_fin','est_active','created_at'];
}
