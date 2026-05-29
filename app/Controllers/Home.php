<?php

namespace App\Controllers;

use App\Models\Affectations as AffectationsModel;
use App\Models\Notes as NotesModel;
use App\Models\Periodes as PeriodesModel;
use App\Models\SupportsCours as SupportsModel;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }
    public function notifications(): string
    {
        return view('pages/notifications');
    }
    public function actualites(): string
    {
        return view('pages/actualites');
    }

// Section directeur
    public function directeur_dashboard(): string
    {
        return view('directeur/dashboard');
    }
    public function ecolages(): string
    {
        return view('directeur/ecolages');
    }
    public function finance(): string
    {
        return view('directeur/finance');
    }
    public function professeurs(): string
    {
        return view('directeur/professeurs');
    }
    public function profil_prof(): string
    {
        return view('directeur/profil_prof');
    }

// Secteur secretariat
    public function bilan(): string
    {
        return view('secretariat/bilan');
    }
    public function eleves(): string
    {
        return view('secretariat/eleves');
    }
    public function paiement(): string
    {
        return view('secretariat/paiement');
    }
    public function profil_eleve(): string
    {
        return view('secretariat/profil_eleve');
    }

// Secteur professeurs
    public function bulletin_prof(): string
    {
        return view('professeur/bulletin');
    }
    public function calendar_prof(): string
    {
        return view('professeur/calendar');
    }
    public function notes_prof(): string
    {
        $affectationsModel = new AffectationsModel();
        $notesModel = new NotesModel();
        $periodesModel = new PeriodesModel();

        $selectedPeriodeId = $this->request->getGet('periode_id');
        $selectedPeriodeId = $selectedPeriodeId !== null && $selectedPeriodeId !== '' ? (int) $selectedPeriodeId : null;

        $professeurId = $this->request->getGet('professeur_id');
        $professeurId = $professeurId !== null && $professeurId !== '' ? (int) $professeurId : null;

        $affectations = $affectationsModel->getAllAssignementsProf($professeurId);
        $selectedAffectationId = $this->request->getGet('affectation_id');
        $selectedAffectationId = $selectedAffectationId !== null && $selectedAffectationId !== '' ? (int) $selectedAffectationId : null;

        if ($selectedAffectationId === null && !empty($affectations)) {
            $selectedAffectationId = (int) $affectations[0]['id'];
        }

        $periodes = $periodesModel->orderBy('ordre', 'ASC')->findAll();

        if ($selectedPeriodeId === null && !empty($periodes)) {
            $selectedPeriodeId = (int) $periodes[0]['id'];
        }

        $noteData = $selectedAffectationId !== null
            ? $notesModel->getNotesByAffectation($selectedAffectationId, $selectedPeriodeId)
            : ['affectation' => null, 'students' => [], 'evaluation_types' => [], 'notes' => []];

        return view('professeur/note', [
            'affectations' => $affectations,
            'selectedAffectationId' => $selectedAffectationId,
            'selectedPeriodeId' => $selectedPeriodeId,
            'periodes' => $periodes,
            'noteData' => $noteData,
        ]);
    }
    public function profil(): string
    {
        return view('professeur/profil_prof');
    }
    public function devoirs_prof(): string
    {
        $supportsModel = new SupportsModel();
        $supportCours = $supportsModel->getPublishedSupports();
        $options = $supportsModel->getPublishFormOptions();

        return view('professeur/devoir', [
            'supportCours' => $supportCours,
            'classes' => $options['classes'],
            'typesFichiers' => $options['types_fichiers'],
            'affectations' => $options['affectations'],
            'matieres' => $options['matieres'],
        ]);
    }

// Secteur etudiants
    public function bulletin_etudiants(): string
    {
        return view('etudiant/bulletin');
    }
    public function calendar_etudiants(): string
    {
        return view('etudiant/calendar');
    }
    public function notes_etudiants(): string
    {
        return view('etudiant/note');
    }
    public function devoirs_etudiants(): string
    {
        return view('etudiant/devoir');
    }

}
