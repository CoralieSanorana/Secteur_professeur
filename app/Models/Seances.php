<?php
namespace App\Models;

use CodeIgniter\Model;

class Seances extends Model
{
    protected $table = 'seances';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['emploi_du_temps_id', 'date_seance', 'heure_debut', 'heure_fin', 'a_eu_lieu'];

    protected $validationRules = [
        'emploi_du_temps_id' => 'required|integer',
        'date_seance' => 'required|valid_date[Y-m-d]',
        'heure_debut' => 'permit_empty|valid_date[H:i:s]',
        'heure_fin' => 'permit_empty|valid_date[H:i:s]',
        'a_eu_lieu' => 'permit_empty|in_list[0,1,true,false]',
    ];

    public function getSeancesByProfesseur(int $professeurId, ?string $dateDebut = null, ?string $dateFin = null): array
    {
        $builder = $this->db->table('seances s')
            ->select('s.*')
            ->select('edt.jour_semaine, edt.affectation_id')
            ->select('ae.professeur_id, c.nom AS classe_nom, m.nom AS matiere_nom')
            ->join('emploi_du_temps edt', 'edt.id = s.emploi_du_temps_id')
            ->join('affectations_enseignement ae', 'ae.id = edt.affectation_id')
            ->join('classes c', 'c.id = ae.classe_id')
            ->join('matieres m', 'm.id = ae.matiere_id')
            ->where('ae.professeur_id', $professeurId)
            ->orderBy('s.date_seance', 'ASC')
            ->orderBy('COALESCE(s.heure_debut, edt.heure_debut)', 'ASC', false);

        if (!empty($dateDebut)) {
            $builder->where('s.date_seance >=', $dateDebut);
        }

        if (!empty($dateFin)) {
            $builder->where('s.date_seance <=', $dateFin);
        }

        return $builder->get()->getResultArray();
    }
}
