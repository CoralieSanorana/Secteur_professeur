-- Vue pour afficher l'emploi du temps d'un professeur
CREATE OR REPLACE VIEW v_emploi_du_temps_professeur AS
SELECT
	s.id AS seance_id,
	s.jour_semaine,
	s.heure_debut,
	s.heure_fin,
	c.id AS classe_id,
	c.nom AS classe_nom,
	m.id AS matiere_id,
	m.nom AS matiere_nom,
	sa.id AS salle_id,
	sa.nom AS salle_nom,
	pp.id AS professeur_id,
	pp.nom AS professeur_nom,
	pp.prenom AS professeur_prenom
FROM seances s
JOIN emploi_du_temps edt ON edt.id = s.emploi_du_temps_id
JOIN classes c ON c.id = edt.classe_id
JOIN affectations_enseignement ae ON ae.id = s.affectation_id
JOIN matieres m ON m.id = ae.matiere_id
JOIN salles sa ON sa.id = s.salle_id
JOIN profils_professeurs pp ON pp.id = ae.professeur_id
ORDER BY s.jour_semaine, s.heure_debut;

-- ============================================================
-- DONNÉES DE TEST POUR L'AFFICHAGE DE L'EMPLOI DU TEMPS
-- Un seul professeur et exactement deux séances associées.
-- ============================================================

DO $$
DECLARE
	v_etablissement_id INT;
	v_niveau_id INT;
	v_annee_id INT;
	v_periode_id INT;
	v_classe_id INT;
	v_matiere_id INT;
	v_salle_id INT;
	v_prof_id INT;
	v_affectation_id INT;
	v_edt_id INT;
BEGIN
	SELECT id INTO v_etablissement_id
	FROM etablissements
	WHERE nom = 'Ecole de test EDT professeur'
	LIMIT 1;

	IF v_etablissement_id IS NULL THEN
		INSERT INTO etablissements (nom, adresse, telephone, email)
		VALUES (
			'Ecole de test EDT professeur',
			'Adresse de test',
			'0000 000 000',
			'test-edt@ecole.local'
		)
		RETURNING id INTO v_etablissement_id;
	END IF;

	SELECT id INTO v_niveau_id
	FROM niveaux
	WHERE libelle = 'Niveau test EDT'
	LIMIT 1;

	IF v_niveau_id IS NULL THEN
		INSERT INTO niveaux (etablissement_id, libelle, ordre)
		VALUES (v_etablissement_id, 'Niveau test EDT', 1)
		RETURNING id INTO v_niveau_id;
	END IF;

	SELECT id INTO v_annee_id
	FROM annees_scolaires
	WHERE libelle = '2025-2026 TEST EDT'
	LIMIT 1;

	IF v_annee_id IS NULL THEN
		INSERT INTO annees_scolaires (etablissement_id, libelle, date_debut, date_fin, est_active)
		VALUES (v_etablissement_id, '2025-2026 TEST EDT', '2025-09-01', '2026-06-30', TRUE)
		RETURNING id INTO v_annee_id;
	END IF;

	SELECT id INTO v_periode_id
	FROM periodes
	WHERE libelle = 'Test EDT - Période 1'
	LIMIT 1;

	IF v_periode_id IS NULL THEN
		INSERT INTO periodes (annee_scolaire_id, libelle, type, ordre, date_debut, date_fin, est_cloturee)
		VALUES (v_annee_id, 'Test EDT - Période 1', 'trimestre', 1, '2026-04-01', '2026-06-30', FALSE)
		RETURNING id INTO v_periode_id;
	END IF;

	SELECT id INTO v_classe_id
	FROM classes
	WHERE nom = 'Terminale Test EDT'
	LIMIT 1;

	IF v_classe_id IS NULL THEN
		INSERT INTO classes (niveau_id, annee_scolaire_id, nom, capacite_max)
		VALUES (v_niveau_id, v_annee_id, 'Terminale Test EDT', 30)
		RETURNING id INTO v_classe_id;
	END IF;

	SELECT id INTO v_matiere_id
	FROM matieres
	WHERE code = 'MATH-EDT-TEST'
	LIMIT 1;

	IF v_matiere_id IS NULL THEN
		INSERT INTO matieres (etablissement_id, nom, code)
		VALUES (v_etablissement_id, 'Mathématiques test EDT', 'MATH-EDT-TEST')
		RETURNING id INTO v_matiere_id;
	END IF;

	SELECT id INTO v_salle_id
	FROM salles
	WHERE nom = 'Salle test EDT 1'
	LIMIT 1;

	IF v_salle_id IS NULL THEN
		INSERT INTO salles (etablissement_id, nom, capacite, type, is_active)
		VALUES (v_etablissement_id, 'Salle test EDT 1', 40, 'cours', TRUE)
		RETURNING id INTO v_salle_id;
	END IF;

	SELECT id INTO v_prof_id
	FROM profils_professeurs
	WHERE matricule = 'PROF-TEST-EDT-001'
	LIMIT 1;

	IF v_prof_id IS NULL THEN
		INSERT INTO profils_professeurs (
			user_id,
			matricule,
			nom,
			prenom,
			date_naissance,
			sexe,
			telephone,
			adresse,
			specialite,
			type_contrat,
			date_debut_contrat,
			is_archived
		)
		VALUES (
			NULL,
			'PROF-TEST-EDT-001',
			'Rakoto',
			'Andry',
			'1985-03-12',
			'M',
			'034 00 000 00',
			'Adresse de test',
			'Mathématiques',
			'permanent',
			'2026-01-01',
			FALSE
		)
		RETURNING id INTO v_prof_id;
	END IF;

	SELECT id INTO v_affectation_id
	FROM affectations_enseignement
	WHERE professeur_id = v_prof_id
	  AND matiere_id = v_matiere_id
	  AND classe_id = v_classe_id
	  AND annee_scolaire_id = v_annee_id
	LIMIT 1;

	IF v_affectation_id IS NULL THEN
		INSERT INTO affectations_enseignement (
			professeur_id,
			matiere_id,
			classe_id,
			annee_scolaire_id,
			heures_hebdo
		)
		VALUES (
			v_prof_id,
			v_matiere_id,
			v_classe_id,
			v_annee_id,
			2.0
		)
		RETURNING id INTO v_affectation_id;
	END IF;

	SELECT id INTO v_edt_id
	FROM emploi_du_temps
	WHERE classe_id = v_classe_id
	  AND periode_id = v_periode_id
	LIMIT 1;

	IF v_edt_id IS NULL THEN
		INSERT INTO emploi_du_temps (classe_id, periode_id)
		VALUES (v_classe_id, v_periode_id)
		RETURNING id INTO v_edt_id;
	END IF;

	IF NOT EXISTS (
		SELECT 1
		FROM seances
		WHERE emploi_du_temps_id = v_edt_id
		  AND jour_semaine = 1
		  AND heure_debut = TIME '08:00'
		  AND heure_fin = TIME '10:00'
	) THEN
		INSERT INTO seances (
			emploi_du_temps_id,
			jour_semaine,
			heure_debut,
			heure_fin,
			affectation_id,
			salle_id,
			a_eu_lieu
		)
		VALUES (
			v_edt_id,
			1,
			TIME '08:00',
			TIME '10:00',
			v_affectation_id,
			v_salle_id,
			TRUE
		);
	END IF;

	IF NOT EXISTS (
		SELECT 1
		FROM seances
		WHERE emploi_du_temps_id = v_edt_id
		  AND jour_semaine = 3
		  AND heure_debut = TIME '14:00'
		  AND heure_fin = TIME '16:00'
	) THEN
		INSERT INTO seances (
			emploi_du_temps_id,
			jour_semaine,
			heure_debut,
			heure_fin,
			affectation_id,
			salle_id,
			a_eu_lieu
		)
		VALUES (
			v_edt_id,
			3,
			TIME '14:00',
			TIME '16:00',
			v_affectation_id,
			v_salle_id,
			TRUE
		);
	END IF;
END $$;