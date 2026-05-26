-- ============================================================
-- MIGRATION : Ancien schéma → Nouveau schéma
-- ============================================================

-- ============================================================
-- 1. SUPPRIMER LES CONTRAINTES (pour éviter les erreurs)
-- ============================================================
ALTER TABLE seances DROP CONSTRAINT IF EXISTS seances_emploi_du_temps_id_fkey;
ALTER TABLE seances DROP CONSTRAINT IF EXISTS seances_matiere_id_fkey;
ALTER TABLE seances DROP CONSTRAINT IF EXISTS seances_professeur_id_fkey;
ALTER TABLE notes DROP CONSTRAINT IF EXISTS notes_matiere_id_fkey;
ALTER TABLE notes DROP CONSTRAINT IF EXISTS notes_professeur_id_fkey;
ALTER TABLE notes DROP CONSTRAINT IF EXISTS notes_etudiant_id_fkey;
ALTER TABLE notes DROP CONSTRAINT IF EXISTS notes_periode_id_fkey;
ALTER TABLE absences DROP CONSTRAINT IF EXISTS absences_seance_id_fkey;
ALTER TABLE modifications_edt DROP CONSTRAINT IF EXISTS modifications_edt_emploi_du_temps_id_fkey;
ALTER TABLE moyennes DROP CONSTRAINT IF EXISTS moyennes_periode_id_fkey;

-- ============================================================
-- 2. SUPPRIMER LES ANCIENNES TABLES
-- ============================================================
DROP TABLE IF EXISTS emploi_temps CASCADE;
DROP TABLE IF EXISTS absence CASCADE;
DROP TABLE IF EXISTS devoir_lecon CASCADE;
DROP TABLE IF EXISTS note CASCADE;
DROP TABLE IF EXISTS periode CASCADE;
DROP TABLE IF EXISTS matiere CASCADE;

-- ============================================================
-- 3. SUPPRIMER LES INDEX OBSOLÈTES
-- ============================================================
DROP INDEX IF EXISTS idx_edt_affectation;
DROP INDEX IF EXISTS idx_edt_validite;
DROP INDEX IF EXISTS idx_modif_edt_date;
DROP INDEX IF EXISTS idx_notes_etudiant;
DROP INDEX IF EXISTS idx_notes_affectation;
DROP INDEX IF EXISTS idx_notes_periode;

-- ============================================================
-- 4. AJOUTER LES NOUVELLES COLONNES DANS SEANCES
-- ============================================================
ALTER TABLE seances ADD COLUMN IF NOT EXISTS est_annule BOOLEAN DEFAULT FALSE;
ALTER TABLE seances ALTER COLUMN emploi_du_temps_id SET NOT NULL;

-- ============================================================
-- 5. RECRÉER LES TABLES AVEC LA NOUVELLE STRUCTURE
-- ============================================================

-- Table periodes (remplace periode)
DROP TABLE IF EXISTS periodes CASCADE;
CREATE TABLE periodes (
    id                 SERIAL PRIMARY KEY,
    libelle            VARCHAR(60) NOT NULL,
    type_periode       VARCHAR(20) NOT NULL CHECK (type_periode IN ('trimestre','semestre','annuel')),
    date_debut         DATE NOT NULL,
    date_fin           DATE NOT NULL,
    annee_scolaire_id  INT NOT NULL REFERENCES annees_scolaires(id),
    created_at         TIMESTAMP DEFAULT NOW(),
    CHECK (date_fin > date_debut)
);

-- Table matieres (remplace matiere)
DROP TABLE IF EXISTS matieres CASCADE;
CREATE TABLE matieres (
    id          SERIAL PRIMARY KEY,
    code_matiere VARCHAR(20) NOT NULL UNIQUE,
    intitule    VARCHAR(150) NOT NULL,
    coefficient NUMERIC(4,2) NOT NULL DEFAULT 1 CHECK (coefficient > 0),
    unite       VARCHAR(50),
    niveau      VARCHAR(30),
    serie       VARCHAR(30),
    created_at  TIMESTAMP DEFAULT NOW()
);

-- Table emploi_du_temps (remplace emploi_temps)
DROP TABLE IF EXISTS emploi_du_temps CASCADE;
CREATE TABLE emploi_du_temps (
    id                SERIAL PRIMARY KEY,
    classe_id         INT NOT NULL REFERENCES classes(id),
    periode_id        INT NOT NULL REFERENCES periodes(id),
    created_at        TIMESTAMP DEFAULT NOW()
);

-- Table seances (ajout de est_annule)
DROP TABLE IF EXISTS seances CASCADE;
CREATE TABLE seances (
    id                SERIAL PRIMARY KEY,
    emploi_du_temps_id INT NOT NULL REFERENCES emploi_du_temps(id) ON DELETE CASCADE,
    jour_semaine       VARCHAR(10) NOT NULL,
    heure_debut        TIME NOT NULL,
    heure_fin          TIME NOT NULL,
    matiere_id         INT NOT NULL REFERENCES matieres(id),
    professeur_id      INT NOT NULL REFERENCES profils_professeurs(id),
    salle_id           INT REFERENCES salles(id),
    est_annule         BOOLEAN DEFAULT FALSE,
    created_at         TIMESTAMP DEFAULT NOW(),
    CHECK (heure_fin > heure_debut)
);

-- Table notes (remplace note)
DROP TABLE IF EXISTS notes CASCADE;
CREATE TABLE notes (
    id_note         SERIAL PRIMARY KEY,
    valeur          NUMERIC(5,2) NOT NULL CHECK (valeur BETWEEN 0 AND 20),
    type_evaluation VARCHAR(30) NOT NULL CHECK (type_evaluation IN ('devoir','interrogation','examen','composition','TP','oral')),
    date_evaluation DATE NOT NULL,
    observation     TEXT,
    etudiant_id     INT REFERENCES profils_etudiants(id) ON DELETE CASCADE,
    matiere_id      INT REFERENCES matieres(id) ON DELETE RESTRICT,
    professeur_id   INT REFERENCES profils_professeurs(id) ON DELETE RESTRICT,
    periode_id      INT REFERENCES periodes(id) ON DELETE RESTRICT,
    created_at      TIMESTAMP DEFAULT NOW()
);

-- ============================================================
-- 6. RECRÉER LES INDEX
-- ============================================================
CREATE INDEX idx_seances_date ON seances(created_at);
CREATE INDEX idx_notes_etudiant ON notes(etudiant_id);
CREATE INDEX idx_notes_periode ON notes(periode_id);
CREATE INDEX idx_notes_matiere ON notes(matiere_id);

-- ============================================================
-- 7. TRANSFÉRER LES DONNÉES (si nécessaire)
-- ============================================================
-- Note : Cette partie dépend de vos données existantes
-- Si vous aviez des données dans les anciennes tables, exécutez :
/*
INSERT INTO matieres (code_matiere, intitule, coefficient, created_at)
SELECT code_matiere, intitule, coefficient, created_at FROM matiere;

INSERT INTO periodes (libelle, type_periode, date_debut, date_fin, annee_scolaire_id)
SELECT libelle, type_periode, date_debut, date_fin, 1 FROM periode;
*/

-- ============================================================
-- RÉINITIALISER LES SÉQUENCES
-- ============================================================
ALTER SEQUENCE periodes_id_seq RESTART WITH 1;
ALTER SEQUENCE matieres_id_seq RESTART WITH 1;
ALTER SEQUENCE emploi_du_temps_id_seq RESTART WITH 1;
ALTER SEQUENCE seances_id_seq RESTART WITH 1;
ALTER SEQUENCE notes_id_note_seq RESTART WITH 1;

-- ============================================================
-- FIN DE LA MIGRATION
-- ============================================================
\echo 'Migration terminée avec succès !'
\echo 'Tables supprimées : emploi_temps, absence, devoir_lecon, note, periode, matiere'
\echo 'Tables créées : periodes, matieres, emploi_du_temps, seances, notes'