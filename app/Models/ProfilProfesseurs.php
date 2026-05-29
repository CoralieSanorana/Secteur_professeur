<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfilProfesseurs extends Model
{
    protected $table = 'profils_professeurs';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['user_id','matricule','nom','prenom','date_naissance','sexe','photo_url','telephone','adresse','specialite','type_contrat','date_debut_contrat','date_fin_contrat','is_archived','created_at','updated_at','id_contrat','id_matiere'];
    
    /**
     * Récupère toutes les informations d'un prof avec son contrat et ses matières
     */
    public function getInfoProf($professeurId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('profils_professeurs pp');
        
        $result = $builder->select('pp.*, 
                                    ce.salaire_mensuel,
                                    ce.date_debut as date_embauche,
                                    ce.date_fin as fin_contrat,
                                    tce.libelle as type_contrat_libelle,
                                    u.email')
                         ->join('contrats_employes ce', 'ce.id = pp.id_contrat', 'left')
                         ->join('types_contrats_employes tce', 'tce.id = ce.type_contrat_id', 'left')
                         ->join('users u', 'u.id = pp.user_id', 'left')
                         ->where('pp.id', $professeurId)
                         ->get()
                         ->getRowArray();
        
        if ($result) {
            // Récupérer les matières enseignées
            $matieres = $db->table('affectations_enseignement ae')
                          ->select('m.id, m.nom, m.code, ae.heures_hebdo, c.nom as classe_nom')
                          ->join('matieres m', 'm.id = ae.matiere_id')
                          ->join('classes c', 'c.id = ae.classe_id')
                          ->join('annees_scolaires aa', 'aa.id = ae.annee_scolaire_id')
                          ->where('ae.professeur_id', $professeurId)
                          ->where('aa.est_active', true)
                          ->get()
                          ->getResultArray();
            
            $result['matieres_enseignees'] = $matieres;
        }
        
        return $result;
    }
}