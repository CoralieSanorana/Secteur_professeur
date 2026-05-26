<?php

namespace App\Controllers;

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
        return view('professeur/note');
    }
    public function profil(): string
    {
        return view('professeur/profil_prof');
    }
    public function devoirs_prof(): string
    {
        return view('professeur/devoir');
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
