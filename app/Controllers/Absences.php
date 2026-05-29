<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Absences as AbsencesModel;
use App\Models\Seances as SeancesModel;

class Absences extends BaseController
{
    public function index(){ return $this->response->setJSON((new AbsencesModel())->findAll()); }
    public function show($id){ return $this->response->setJSON((new AbsencesModel())->find($id)); }
    public function create(){ $data=$this->request->getJSON(true); $id=(new AbsencesModel())->insert($data); return $this->response->setJSON(['id'=>$id]); }
    public function update($id){ $data=$this->request->getJSON(true); (new AbsencesModel())->update($id,$data); return $this->response->setJSON(['updated'=>true]); }
    public function delete($id){ (new AbsencesModel())->delete($id); return $this->response->setJSON(['deleted'=>true]); }
    
    /**
     * Affiche la page de gestion des absences pour une classe
     */
    public function gestion($classeId = null, $seanceId = null)
    {
        $model = new AbsencesModel();
        $seanceModel = new SeancesModel();
        
        // Récupérer l'ID du professeur connecté
        $professeurId = session()->get('professeur_id');
        if (!$professeurId) {
            return redirect()->to('/login')->with('error', 'Session expirée');
        }
        
        // Si classeId non fourni, récupérer la première classe du professeur
        if (!$classeId) {
            $classes = $this->getClassesByProfesseur($professeurId);
            if (empty($classes)) {
                return redirect()->back()->with('error', 'Aucune classe assignée');
            }
            $classeId = $classes[0]['id'];
        }
        
        // Récupérer les étudiants de la classe
        $etudiants = $model->getAllEtudiantsClasse($classeId);
        
        // Récupérer la séance du jour pour cette classe
        $aujourdhui = date('Y-m-d');
        $seances = $seanceModel->getSeancesByProfesseur($professeurId, $aujourdhui, $aujourdhui);
        
        // Filtrer les séances par classe
        $seance = null;
        foreach ($seances as $s) {
            // On cherche la séance correspondant à la classe
            if ($seanceId && $s['id'] == $seanceId) {
                $seance = $s;
                break;
            } elseif (!$seanceId) {
                // Prendre la première séance du jour
                $seance = $s;
                $seanceId = $seance['id'];
                break;
            }
        }
        
        // Récupérer les absences existantes
        $absencesExistantes = $seanceId ? $model->getAbsencesBySeance($seanceId) : [];
        $absencesMap = [];
        foreach ($absencesExistantes as $abs) {
            $absencesMap[$abs['etudiant_id']] = $abs;
        }
        
        // Récupérer la liste des classes du professeur pour le sélecteur
        $classes = $this->getClassesByProfesseur($professeurId);
        
        $data = [
            'etudiants' => $etudiants,
            'classeId' => $classeId,
            'seanceId' => $seanceId,
            'seance' => $seance,
            'classes' => $classes,
            'absencesMap' => $absencesMap,
            'pageTitle' => 'Gestion des absences',
            'activePage' => 'prof-absences',
            'activeRole' => 'professeur',
            'userName' => session()->get('user_name') ?? 'Professeur',
            'userRole' => 'Professeur',
            'userInitials' => session()->get('user_initials') ?? 'PR'
        ];
        
        return view('professeur/absence', $data);
    }
    
    /**
     * Enregistre les absences pour une séance
     */
    public function saveAbsencesClass()
    {
        $model = new AbsencesModel();
        
        $seanceId = $this->request->getPost('seance_id');
        $etudiantsIds = $this->request->getPost('etudiant_id') ?? [];
        $types = $this->request->getPost('type') ?? [];
        $motifs = $this->request->getPost('motif') ?? [];
        
        if (!$seanceId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID de séance manquant'
            ]);
        }
        
        $absencesData = [];
        foreach ($etudiantsIds as $index => $etudiantId) {
            $type = $types[$index] ?? 'non_justifiee';
            if ($type !== 'present') {
                $absencesData[] = [
                    'etudiant_id' => $etudiantId,
                    'type' => $type,
                    'motif' => $motifs[$index] ?? null
                ];
            }
        }
        
        $saisiPar = session()->get('user_id');
        $result = $model->saveAbsencesSeance($seanceId, $absencesData, $saisiPar);
        
        if ($result) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Absences enregistrées avec succès',
                'count' => count($absencesData)
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur lors de l\'enregistrement des absences'
            ]);
        }
    }
    
    /**
     * Récupère les classes du professeur connecté
     */
    private function getClassesByProfesseur($professeurId)
    {
        $db = \Config\Database::connect();
        return $db->table('affectations_enseignement ae')
                  ->select('DISTINCT c.id, c.nom, n.libelle as niveau')
                  ->join('classes c', 'c.id = ae.classe_id')
                  ->join('niveaux n', 'n.id = c.niveau_id')
                  ->join('annees_scolaires aa', 'aa.id = ae.annee_scolaire_id')
                  ->where('ae.professeur_id', $professeurId)
                  ->where('aa.est_active', true)
                  ->orderBy('n.ordre', 'ASC')
                  ->orderBy('c.nom', 'ASC')
                  ->get()
                  ->getResultArray();
    }
    
    /**
     * API pour récupérer les étudiants d'une classe (AJAX)
     */
    public function getAllEtudiantsClasse()
    {
        $classeId = $this->request->getGet('classe_id');
        $model = new AbsencesModel();
        $etudiants = $model->getAllEtudiantsClasse($classeId);
        
        return $this->response->setJSON([
            'success' => true,
            'data' => $etudiants
        ]);
    }
}