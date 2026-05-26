<?php
namespace App\Models;

use CodeIgniter\Model;

class SupportsCours extends Model
{
    protected $table = 'supports_cours';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['affectation_id', 'type_fichier_id', 'titre', 'description', 'fichier_url', 'type_contenu', 'date_limite', 'accepte_retard', 'is_archived', 'cree_par'];

    protected $validationRules = [
        'affectation_id' => 'required|integer',
        'type_fichier_id' => 'permit_empty|integer',
        'titre' => 'required|min_length[3]|max_length[255]',
        'description' => 'permit_empty',
        'type_contenu' => 'required|in_list[lecon,exercice,devoir_maison]',
        'date_limite' => 'permit_empty|valid_date[Y-m-d H:i:s]',
        'accepte_retard' => 'permit_empty|in_list[0,1,true,false]',
        'is_archived' => 'permit_empty|in_list[0,1,true,false]',
    ];

    public function getPublishedSupports(): array
    {
        return $this->db->table('supports_cours sc')
            ->select('sc.*')
            ->select('tf.libelle AS type_fichier_libelle')
            ->select('a.heures_hebdo')
            ->select('c.nom AS classe_nom')
            ->select('m.nom AS matiere_nom')
            ->select('pp.nom AS professeur_nom, pp.prenom AS professeur_prenom')
            ->join('types_fichiers tf', 'tf.id = sc.type_fichier_id', 'left')
            ->join('affectations_enseignement a', 'a.id = sc.affectation_id', 'left')
            ->join('classes c', 'c.id = a.classe_id', 'left')
            ->join('matieres m', 'm.id = a.matiere_id', 'left')
            ->join('profils_professeurs pp', 'pp.id = a.professeur_id', 'left')
            ->where('sc.is_archived', false)
            ->orderBy('sc.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getPublishFormOptions(): array
    {
        return [
            'classes' => $this->db->table('classes')->select('id, nom')->orderBy('nom', 'ASC')->get()->getResultArray(),
            'types_fichiers' => $this->db->table('types_fichiers')->select('id, libelle')->orderBy('libelle', 'ASC')->get()->getResultArray(),
            'matieres' => $this->db->table('matieres')->select('id, nom')->orderBy('nom', 'ASC')->get()->getResultArray(),
            'affectations' => $this->db->table('affectations_enseignement ae')
                ->select('ae.id, ae.professeur_id, ae.classe_id, ae.matiere_id, c.nom AS classe_nom, m.nom AS matiere_nom, pp.nom AS professeur_nom, pp.prenom AS professeur_prenom')
                ->join('classes c', 'c.id = ae.classe_id')
                ->join('matieres m', 'm.id = ae.matiere_id')
                ->join('profils_professeurs pp', 'pp.id = ae.professeur_id')
                ->orderBy('c.nom', 'ASC')
                ->orderBy('m.nom', 'ASC')
                ->get()
                ->getResultArray(),
        ];
    }
}
