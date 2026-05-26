<?php
namespace App\Models;

use CodeIgniter\Model;

class EmploiDuTemps extends Model
{
    protected $table = 'emploi_du_temps';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['affectation_id', 'salle_id', 'jour_semaine', 'heure_debut', 'heure_fin', 'date_debut_validite', 'date_fin_validite'];

    protected $validationRules = [
        'affectation_id' => 'required|integer',
        'salle_id' => 'permit_empty|integer',
        'jour_semaine' => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[6]',
        'heure_debut' => 'required|valid_date[H:i:s]',
        'heure_fin' => 'required|valid_date[H:i:s]',
        'date_debut_validite' => 'permit_empty|valid_date[Y-m-d]',
        'date_fin_validite' => 'permit_empty|valid_date[Y-m-d]',
    ];

    public function getEmploiDuTempsByProfesseur($professeurId)
    {
        return $this->db->table('seances s')
            ->select('s.id AS seance_id')
            ->select('s.date_seance')
            ->select('edt.jour_semaine')
            ->select('COALESCE(s.heure_debut, edt.heure_debut) AS heure_debut', false)
            ->select('COALESCE(s.heure_fin, edt.heure_fin) AS heure_fin', false)
            ->select('c.id AS classe_id, c.nom AS classe_nom')
            ->select('m.id AS matiere_id, m.nom AS matiere_nom')
            ->select('sa.id AS salle_id, sa.nom AS salle_nom')
            ->select('pp.id AS professeur_id, pp.nom AS professeur_nom, pp.prenom AS professeur_prenom')
            ->join('emploi_du_temps edt', 'edt.id = s.emploi_du_temps_id')
            ->join('affectations_enseignement ae', 'ae.id = edt.affectation_id')
            ->join('classes c', 'c.id = ae.classe_id')
            ->join('matieres m', 'm.id = ae.matiere_id')
            ->join('profils_professeurs pp', 'pp.id = ae.professeur_id')
            ->join('salles sa', 'sa.id = edt.salle_id', 'left')
            ->where('ae.professeur_id', (int) $professeurId)
            ->where('s.a_eu_lieu', true)
            ->orderBy('edt.jour_semaine', 'ASC')
            ->orderBy('COALESCE(s.heure_debut, edt.heure_debut)', 'ASC', false)
            ->get()
            ->getResultArray();
    }
}