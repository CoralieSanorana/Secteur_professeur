-- ============================================================
--  DONNEES DE TEST - PARTIE PROFESSEUR
--  Jeu minimal pour verifier : affectations, notes, bulletin,
--  calendrier et affichage des etudiants d'une classe.
-- ============================================================

BEGIN;

-- Rles de base utilises par les comptes de test
INSERT INTO roles (id, nom, description)
VALUES
	(1, 'professeur', 'Compte enseignant de test'),
	(2, 'etudiant', 'Compte eleve de test')
ON CONFLICT (nom) DO NOTHING;

-- Comptes utilisateur
INSERT INTO users (id, email, password_hash, is_active)
VALUES
	(1, 'prof.rabe@example.com', 'test-password-hash', TRUE),
	(2, 'jean.rakoto@example.com', 'test-password-hash', TRUE),
	(3, 'miora.andria@example.com', 'test-password-hash', TRUE)
ON CONFLICT (email) DO NOTHING;

INSERT INTO user_roles (user_id, role_id)
VALUES
	(1, 1),
	(2, 2),
	(3, 2)
ON CONFLICT DO NOTHING;

-- Structure scolaire minimale
INSERT INTO etablissements (id, nom, adresse, telephone, email)
VALUES
	(1, 'Lycee Baovola Test', 'Antananarivo, Madagascar', '034 00 000 00', 'contact@lyceebaovola.test')
ON CONFLICT DO NOTHING;

INSERT INTO annees_scolaires (id, etablissement_id, libelle, date_debut, date_fin, est_active)
VALUES
	(1, 1, '2025-2026', '2025-09-01', '2026-07-15', TRUE)
ON CONFLICT DO NOTHING;

INSERT INTO niveaux (id, etablissement_id, libelle, ordre)
VALUES
	(1, 1, 'Terminale', 3)
ON CONFLICT DO NOTHING;

INSERT INTO classes (id, niveau_id, annee_scolaire_id, nom, capacite_max)
VALUES
	(1, 1, 1, 'Terminale C', 40)
ON CONFLICT DO NOTHING;

INSERT INTO matieres (id, etablissement_id, nom, code)
VALUES
	(1, 1, 'Mathematiques', 'MATH')
ON CONFLICT DO NOTHING;

INSERT INTO periodes (id, annee_scolaire_id, libelle, type, ordre, date_debut, date_fin, date_publication_notes, est_cloturee)
VALUES
	(1, 1, 'Trimestre 1', 'trimestre', 1, '2025-09-01', '2025-12-20', '2025-12-25', FALSE),
	(2, 1, 'Trimestre 2', 'trimestre', 2, '2026-01-06', '2026-04-20', '2026-04-25', FALSE)
ON CONFLICT DO NOTHING;

-- Professeur de test
INSERT INTO profils_professeurs (
	id, user_id, matricule, nom, prenom, date_naissance, sexe,
	photo_url, telephone, adresse, specialite, type_contrat,
	date_debut_contrat, date_fin_contrat, is_archived
)
VALUES
	(
		1,
		1,
		'PROF-001',
		'Rabe',
		'Hery',
		'1985-03-12',
		'M',
		NULL,
		'034 12 345 67',
		'Antananarivo',
		'Mathematiques',
		'permanent',
		'2025-09-01',
		NULL,
		FALSE
	)
ON CONFLICT DO NOTHING;

-- Eleves de test
INSERT INTO profils_etudiants (
	id, user_id, matricule, nom, prenom, date_naissance, lieu_naissance,
	sexe, photo_url, adresse, commune, region, nationalite, cin,
	telephone, is_archived
)
VALUES
	(
		1,
		2,
		'ELV-001',
		'Rakoto',
		'Jean',
		'2008-02-14',
		'Antananarivo',
		'M',
		NULL,
		'Quartier Ambohipo',
		'Antananarivo',
		'Analamanga',
		'Malagasy',
		'123456789012',
		'034 11 111 11',
		FALSE
	),
	(
		2,
		3,
		'ELV-002',
		'Andria',
		'Miora',
		'2008-08-22',
		'Toamasina',
		'F',
		NULL,
		'Quartier Ankadifotsy',
		'Antananarivo',
		'Analamanga',
		'Malagasy',
		'123456789013',
		'034 22 222 22',
		FALSE
	)
ON CONFLICT DO NOTHING;

-- Inscriptions dans la classe de test
INSERT INTO inscriptions (
	id, etudiant_id, classe_id, annee_scolaire_id,
	type_inscription, date_inscription, statut, rang_final, est_admis
)
VALUES
	(1, 1, 1, 1, 'nouvelle', '2025-09-05', 'active', NULL, NULL),
	(2, 2, 1, 1, 'nouvelle', '2025-09-05', 'active', NULL, NULL)
ON CONFLICT DO NOTHING;

-- Affectation unique pour tester la partie professeur
INSERT INTO affectations_enseignement (
	id, professeur_id, matiere_id, classe_id, annee_scolaire_id, heures_hebdo
)
VALUES
	(1, 1, 1, 1, 1, 4.0)
ON CONFLICT DO NOTHING;

-- Salle et emploi du temps pour le calendrier professeur
INSERT INTO salles (id, etablissement_id, nom, capacite, type, is_active)
VALUES
	(1, 1, 'Salle 01', 40, 'cours', TRUE)
ON CONFLICT DO NOTHING;

INSERT INTO emploi_du_temps (
	id, affectation_id, salle_id, jour_semaine,
	heure_debut, heure_fin, date_debut_validite, date_fin_validite
)
VALUES
	(1, 1, 1, 1, '08:00:00', '10:00:00', '2025-09-01', NULL)
ON CONFLICT DO NOTHING;

INSERT INTO seances (
	id, emploi_du_temps_id, date_seance, heure_debut, heure_fin, a_eu_lieu
)
VALUES
	(1, 1, '2025-10-13', '08:00:00', '10:00:00', TRUE)
ON CONFLICT DO NOTHING;

INSERT INTO absences (
	id, seance_id, etudiant_id, type, motif, justificatif_url, saisi_par, date_validation
)
VALUES
	(1, 1, 2, 'non_justifiee', 'Absence de test', NULL, 1, NULL)
ON CONFLICT DO NOTHING;

-- Supports de cours pour la page devoirs/lecons
INSERT INTO types_fichiers (id, libelle)
VALUES
	(1, 'Document PDF'),
	(2, 'Lien Externe')
ON CONFLICT DO NOTHING;

INSERT INTO supports_cours (
	id, affectation_id, type_fichier_id, titre, description, fichier_url,
	type_contenu, date_limite, accepte_retard, is_archived, cree_par
)
VALUES
	(
		1,
		1,
		1,
		'Rappels sur les fonctions',
		'Support de test pour la partie professeur.',
		'uploads/supports_cours/test-fonctions.pdf',
		'lecon',
		NULL,
		FALSE,
		FALSE,
		1
	),
	(
		2,
		1,
		2,
		'Exercice - Equations du second degre',
		'Devoir a rendre sur la plateforme.',
		NULL,
		'exercice',
		'2026-04-15 17:00:00',
		TRUE,
		FALSE,
		1
	)
ON CONFLICT DO NOTHING;

-- Quelques notes pour alimenter la page Notes / Bulletin
INSERT INTO notes (
	id, etudiant_id, affectation_id, periode_id, type_evaluation,
	valeur, sur, commentaire, saisi_par, date_saisie, est_valide
)
VALUES
	(1, 1, 1, 1, 'devoir_1', 16, 20, 'Bon travail', 1, '2025-10-10 08:00:00', TRUE),
	(2, 1, 1, 1, 'devoir_2', 15, 20, 'Bonne progression', 1, '2025-11-12 08:00:00', TRUE),
	(3, 1, 1, 1, 'examen', 17, 20, 'Excellent', 1, '2025-12-18 08:00:00', TRUE),
	(4, 2, 1, 1, 'devoir_1', 12, 20, 'Correct', 1, '2025-10-10 09:00:00', TRUE),
	(5, 2, 1, 1, 'devoir_2', 11, 20, 'Peut mieux faire', 1, '2025-11-12 09:00:00', TRUE),
	(6, 2, 1, 1, 'examen', 13, 20, 'Satisfaisant', 1, '2025-12-18 09:00:00', TRUE)
ON CONFLICT DO NOTHING;

SELECT setval(pg_get_serial_sequence('roles', 'id'), COALESCE((SELECT MAX(id) FROM roles), 1), true);
SELECT setval(pg_get_serial_sequence('users', 'id'), COALESCE((SELECT MAX(id) FROM users), 1), true);
SELECT setval(pg_get_serial_sequence('etablissements', 'id'), COALESCE((SELECT MAX(id) FROM etablissements), 1), true);
SELECT setval(pg_get_serial_sequence('annees_scolaires', 'id'), COALESCE((SELECT MAX(id) FROM annees_scolaires), 1), true);
SELECT setval(pg_get_serial_sequence('niveaux', 'id'), COALESCE((SELECT MAX(id) FROM niveaux), 1), true);
SELECT setval(pg_get_serial_sequence('classes', 'id'), COALESCE((SELECT MAX(id) FROM classes), 1), true);
SELECT setval(pg_get_serial_sequence('matieres', 'id'), COALESCE((SELECT MAX(id) FROM matieres), 1), true);
SELECT setval(pg_get_serial_sequence('periodes', 'id'), COALESCE((SELECT MAX(id) FROM periodes), 1), true);
SELECT setval(pg_get_serial_sequence('profils_professeurs', 'id'), COALESCE((SELECT MAX(id) FROM profils_professeurs), 1), true);
SELECT setval(pg_get_serial_sequence('profils_etudiants', 'id'), COALESCE((SELECT MAX(id) FROM profils_etudiants), 1), true);
SELECT setval(pg_get_serial_sequence('inscriptions', 'id'), COALESCE((SELECT MAX(id) FROM inscriptions), 1), true);
SELECT setval(pg_get_serial_sequence('affectations_enseignement', 'id'), COALESCE((SELECT MAX(id) FROM affectations_enseignement), 1), true);
SELECT setval(pg_get_serial_sequence('salles', 'id'), COALESCE((SELECT MAX(id) FROM salles), 1), true);
SELECT setval(pg_get_serial_sequence('emploi_du_temps', 'id'), COALESCE((SELECT MAX(id) FROM emploi_du_temps), 1), true);
SELECT setval(pg_get_serial_sequence('seances', 'id'), COALESCE((SELECT MAX(id) FROM seances), 1), true);
SELECT setval(pg_get_serial_sequence('absences', 'id'), COALESCE((SELECT MAX(id) FROM absences), 1), true);
SELECT setval(pg_get_serial_sequence('types_fichiers', 'id'), COALESCE((SELECT MAX(id) FROM types_fichiers), 1), true);
SELECT setval(pg_get_serial_sequence('supports_cours', 'id'), COALESCE((SELECT MAX(id) FROM supports_cours), 1), true);
SELECT setval(pg_get_serial_sequence('notes', 'id'), COALESCE((SELECT MAX(id) FROM notes), 1), true);

COMMIT;
