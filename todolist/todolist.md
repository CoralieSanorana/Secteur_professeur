# Secteur Professeur

## Coralie
- [ok] Model utils pour le secteur Professeur
  - [ok] Matieres.php
  - [ok] Coefficients.php
  - [ok] Niveaux.php
  - [ok] Classes.php
  - [ok] Salles.php
  - [ok] EmploiDuTemps.php
  - [ok] Seances.php
  - [ok] Absences.php
  - [ok] Notes.php
  - [ok] Moyennes.php
  - [ok] Users.php
  - [ok] ProfilProfesseurs.php
  - [ok] ProfilEtudiants.php
  - [ok] Affectations.php
  - [ok] AnneeScolaires.php
  - [ok] Periodes.php
  - [ok] TypesFichiers.php
  - [ok] SupportsCours.php

## Coralie
- [ok] Controller
  - [ok] Creer un controller por chaque models

## Coralie
- [] Page: professeur/calendar.php
  - [ok] SQL: creer view 'v_emploi_du_temps_professeur' pour obtenir emploi du temps d'un prof 
  - [ok] Fonction php: getEmploiDuTempsByProfesseur() 
    - [ok] recuperer l'emploi du temps d'un prof dans la table 'seances' a partir de son 'id'.
  - [ok] Affichage: afficher sous forme de calendrier son emploi du temps
    - [ok] afficher dans une calendrier hebdomadaire toutes les seances auxquelles le prof est affecte (avec Matiere, Salle, Classe, heure debut, heure fin)
    - [] rendre chaque section de seance clicable pour faire la 'presence'-> redirect->to('professeur/absence.php')
  - [ok] Affichage: ajouter bouton 'Imprimer'

## Bryan
- [] Page: professeur/absence.php
  - [] Fonction php: getAllEtudiantsClasse()
    - [] recuperer tous les etudiants d'une classe
  - [] Affichage: 
    - [] afficher sous forme de tableau la liste des etudiants avec les colonnes: id, matricule, photo, nom+prenom, sex, absence (par defaut 'non'), type, justification
    - [] bouton 'Valider precence'
  - [] Fonction php: saveAbsencesClass()
    - [] enregistrer uniquement les etudiants absent
    - [] return un message (success / error)

## Coralie
- [] Page: professeur/notes.php
  - [] Fonction php: getAllAssignementsProf()
    - [] recuprer toutes les assignements du prof (avec classe, matiere)
  - [] Affichage: 
    - [] afficher toutes les 'classes & matieres' auxquelles le prof est attribue sur une bare fixe en haut
    - [] rendre chaque 'classes & matieres' clicable
      - [] afficher la liste des etudiants de cette classe sous forme de tableau avec les colonnes: id, matricule, nom+penom, les notes precedantes de chaque etudiant (avec nom de colonne = type d'evaluation)
      - [] bouton 'Saisi de note' -> redirect->to(' professeur/saisir_notes.php')

## Itiela
- [] Page: professeur/saisir_notes.php
  - [] Affichage: 
    - [] afficher la liste des etudiants de cette classe sous forme de tableau avec les colonnes: id, matricule, photo, nom+prenom, note, commentaire
      - [] mettre la colonne 'note' saisissable pour saisir les notes de chaque etudiants
    - [] mettre des champs pour saisir 'la periode', 'le type d'evaluation', 'sur(/20 ou /40 ...)'
    - [] bouton 'Valider les notes'
  - [] Fonction php: saveNotesClasse()
    - [] enregistre les notes saisi d'une classe
    - [] return un message (success / error)

## Coralie
- [ok] Page: professeur/devoirs.php
  - [ok] SQL: creer les tables pour les devoirs et exercices
    - [ok] type_fichier ('PDF', 'DOCX', 'Lien externe', etc.)
    - [ok] supports_cours
  - [ok] Affichage: 
    - [ok] afficher les cours deja publier (exo/lecon)
    - [ok] bouton 'Publier cours' -> appel fonction js: formCours()
  - [ok] Foction js: formcours()
    - [ok] un formulaire pour publier des cours avec les champs: classe, type_ficher, titre, description, type_contenu(lecon, exercice), date_limit, upload fichier(pas obligatoire)
  - [ok] Fonction php: saveCours()
    - [ok] enregistrer les cours saisi
    - [ok] return un message (success / error)

## Itiela
- [] Page: professeur/bulletin.php
  - [] Fonction php: 
    - [] getClasseTitulaire()
      - [] recuperer la classe auquelle le prof est titulaire
      - [] recuperer les etudiants de cette classe
    - [] getAllsNotesEtudiant()
      - [] recuperer toutes les notes d'un etudiant par periode(1er trimestre, 2e trimestre, ....)
  - [] Affichage: 
    - [] mettre un champ pour choisir la periode (1er trimestre, 2e trimestre, ....)
    - [] afficher la liste des etudiants dans la classe auquelle le prof est titulaire
    - [] recuperer les notes de chaque etudiant dans toutes les matieres selon la periode choisi
    - [] afficher la moyenne de chaque etudiant
    - [] afficher le rang de chaque etudiant
    - [] afficher la moyenne de classe

## Bryan
- [] Page: professeur/profil.php
  - [] Fonction php: getInfoProf()
    - [] recuperer toutes les informations d'un prof
  - [] Affichage:
    - [] afficher les informations complet du professeur: 
      - [] info personnel: id, nom+prenom, photo, adresse, date d'embauche, contact, salaire
      - [] matieres enseignees

