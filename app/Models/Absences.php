<?php

namespace App\Models;

use CodeIgniter\Model;

class Absences extends Model
{
    protected $table = 'absences';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['seance_id','etudiant_id','type','motif','justificatif_url','saisi_par','valide_par','date_validation','created_at','updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    /**
     * Récupère tous les étudiants d'une classe
     */
    public function getAllEtudiantsClasse($classeId, $anneeScolaireId = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('inscriptions i');
        
        if (!$anneeScolaireId) {
            $anneeActive = $db->table('annees_scolaires')
                              ->where('est_active', true)
                              ->get()
                              ->getRowArray();
            $anneeScolaireId = $anneeActive['id'] ?? null;
        }
        
        return $builder->select('e.id, e.matricule, e.nom, e.prenom, e.sexe, e.photo_url, i.id as inscription_id')
                       ->join('profils_etudiants e', 'e.id = i.etudiant_id')
                       ->where('i.classe_id', $classeId)
                       ->where('i.annee_scolaire_id', $anneeScolaireId)
                       ->where('i.statut', 'active')
                       ->orderBy('e.nom', 'ASC')
                       ->get()
                       ->getResultArray();
    }
    
    /**
     * Enregistre les absences pour une séance
     */
    public function saveAbsencesSeance($seanceId, $absencesData, $saisiPar)
    {
        $db = \Config\Database::connect();
        $db->transStart();
        
        foreach ($absencesData as $absence) {
            $existing = $db->table('absences')
                           ->where('seance_id', $seanceId)
                           ->where('etudiant_id', $absence['etudiant_id'])
                           ->get()
                           ->getRowArray();
            
            if ($existing) {
                $db->table('absences')
                   ->where('id', $existing['id'])
                   ->update([
                       'type' => $absence['type'],
                       'motif' => $absence['motif'] ?? null,
                       'saisi_par' => $saisiPar,
                       'updated_at' => date('Y-m-d H:i:s')
                   ]);
            } else {
                $db->table('absences')->insert([
                    'seance_id' => $seanceId,
                    'etudiant_id' => $absence['etudiant_id'],
                    'type' => $absence['type'],
                    'motif' => $absence['motif'] ?? null,
                    'saisi_par' => $saisiPar,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
        
        $db->transComplete();
        return $db->transStatus();
    }
    
    /**
     * Récupère les absences existantes pour une séance
     */
    public function getAbsencesBySeance($seanceId)
    {
        $db = \Config\Database::connect();
        return $db->table('absences')
                  ->select('etudiant_id, type, motif')
                  ->where('seance_id', $seanceId)
                  ->get()
                  ->getResultArray();
    }
}