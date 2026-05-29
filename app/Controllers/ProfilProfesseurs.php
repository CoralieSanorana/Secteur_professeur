<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProfilProfesseurs as ProfilProfesseursModel;

class ProfilProfesseurs extends BaseController
{
    public function index(){ return $this->response->setJSON((new ProfilProfesseursModel())->findAll()); }
    public function show($id){ return $this->response->setJSON((new ProfilProfesseursModel())->find($id)); }
    public function create(){ $data=$this->request->getJSON(true); $id=(new ProfilProfesseursModel())->insert($data); return $this->response->setJSON(['id'=>$id]); }
    public function update($id){ $data=$this->request->getJSON(true); (new ProfilProfesseursModel())->update($id,$data); return $this->response->setJSON(['updated'=>true]); }
    public function delete($id){ (new ProfilProfesseursModel())->delete($id); return $this->response->setJSON(['deleted'=>true]); }
    
    // Nouvelle méthode pour afficher le profil
    public function profil($id = null)
    {
        $professeurId = $id ?? session()->get('professeur_id');
        $model = new ProfilProfesseursModel();
        $prof = $model->getInfoProf($professeurId);
        
        if (!$prof) {
            return redirect()->back()->with('error', 'Professeur non trouvé');
        }
        
        // Calculer l'ancienneté
        $anciennete = '';
        if (!empty($prof['date_embauche'])) {
            $debut = new \DateTime($prof['date_embauche']);
            $now = new \DateTime();
            $diff = $debut->diff($now);
            $anciennete = $diff->y . ' ans';
        }
        
        // Formater le salaire
        $salaireFormate = !empty($prof['salaire_mensuel']) ? number_format($prof['salaire_mensuel'], 0, ',', ' ') . ' Ar' : 'Non défini';
        
        // Préparer les données pour la vue
        $data = [
            'prof' => $prof,
            'anciennete' => $anciennete,
            'salaireFormate' => $salaireFormate,
            'pageTitle' => 'Mon Profil',
            'activePage' => 'prof-profil',
            'activeRole' => 'professeur',
            'userName' => ($prof['prenom'] ?? '') . ' ' . ($prof['nom'] ?? ''),
            'userRole' => 'Professeur',
            'userInitials' => strtoupper(substr($prof['prenom'] ?? 'P', 0, 1) . substr($prof['nom'] ?? 'R', 0, 1))
        ];
        
        return view('professeur/profil', $data);
    }
}