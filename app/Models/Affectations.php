<?php
namespace App\Models;

use CodeIgniter\Model;

class Affectations extends Model
{
    protected $table = 'affectations_enseignement';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['professeur_id','matiere_id','classe_id','annee_scolaire_id','heures_hebdo','created_at'];

    public function getAllAssignementsProf(?int $professeurId = null): array
    {
        $builder = $this->db->table('affectations_enseignement ae')
            ->select('ae.id, ae.professeur_id, ae.matiere_id, ae.classe_id, ae.annee_scolaire_id, ae.heures_hebdo, ae.created_at')
            ->select('c.nom AS classe_nom')
            ->select('m.nom AS matiere_nom')
            ->select('pp.nom AS professeur_nom, pp.prenom AS professeur_prenom')
            ->select('an.libelle AS annee_scolaire_libelle, an.est_active AS annee_scolaire_active')
            ->join('classes c', 'c.id = ae.classe_id', 'left')
            ->join('matieres m', 'm.id = ae.matiere_id', 'left')
            ->join('profils_professeurs pp', 'pp.id = ae.professeur_id', 'left')
            ->join('annees_scolaires an', 'an.id = ae.annee_scolaire_id', 'left')
            ->orderBy('ae.created_at', 'DESC')
            ->orderBy('c.nom', 'ASC')
            ->orderBy('m.nom', 'ASC');

        if ($professeurId !== null) {
            $builder->where('ae.professeur_id', $professeurId);
        }

        return $builder->get()->getResultArray();
    }

    public function getAssignementById(int $id): ?array
    {
        $row = $this->db->table('affectations_enseignement ae')
            ->select('ae.id, ae.professeur_id, ae.matiere_id, ae.classe_id, ae.annee_scolaire_id, ae.heures_hebdo, ae.created_at')
            ->select('c.nom AS classe_nom')
            ->select('m.nom AS matiere_nom')
            ->select('pp.nom AS professeur_nom, pp.prenom AS professeur_prenom')
            ->select('an.libelle AS annee_scolaire_libelle, an.est_active AS annee_scolaire_active')
            ->join('classes c', 'c.id = ae.classe_id', 'left')
            ->join('matieres m', 'm.id = ae.matiere_id', 'left')
            ->join('profils_professeurs pp', 'pp.id = ae.professeur_id', 'left')
            ->join('annees_scolaires an', 'an.id = ae.annee_scolaire_id', 'left')
            ->where('ae.id', $id)
            ->get()
            ->getRowArray();

        return $row ?: null;
    }
}
