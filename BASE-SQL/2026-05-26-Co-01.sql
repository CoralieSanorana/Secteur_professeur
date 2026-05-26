-- ============================================================
-- Base de données 'ecole_db'
-- ============================================================

DROP TABLE IF EXISTS emploi_du_temps CASCADE;
CREATE TABLE emploi_du_temps (
    id                SERIAL PRIMARY KEY,
    classe_id         INT NOT NULL REFERENCES classes(id),
    periode_id        INT NOT NULL REFERENCES periodes(id),
    created_at        TIMESTAMP DEFAULT NOW()
);

DROP TABLE IF EXISTS seances CASCADE;
CREATE TABLE seances (
    id                SERIAL PRIMARY KEY,
    emploi_du_temps_id INT NOT NULL REFERENCES emploi_du_temps(id) ON DELETE CASCADE,
    jour_semaine       INT NOT NULL CHECK (jour_semaine BETWEEN 1 AND 6),
    -- 1=Lundi, 2=Mardi, 3=Mercredi, 4=Jeudi, 5=Vendredi, 6=Samedi
    heure_debut        TIME NOT NULL,
    heure_fin          TIME NOT NULL,
    affectation_id      INT REFERENCES affectations_enseignement(id),
    salle_id           INT REFERENCES salles(id),
    a_eu_lieu          BOOLEAN DEFAULT TRUE,
    created_at         TIMESTAMP DEFAULT NOW(),
    CHECK (heure_fin > heure_debut)
);


-- ============================================================
-- SECTION 18 — LEÇONS, EXERCICES & RENDUS (CAHIER DE TEXTE / LMD)
-- Équipe Professeur : Publication de supports et devoirs.
-- Équipe Étudiant   : Téléchargement et rendu des devoirs.
-- ============================================================

-- Formats de fichiers acceptés (ex: 'PDF', 'Word', 'Lien Vidéo YouTube', 'Audio')
CREATE TABLE types_fichiers (
    id          SERIAL PRIMARY KEY,
    libelle     VARCHAR(100) UNIQUE NOT NULL, -- 'PDF', 'DOCX', 'Lien externe', etc.
    created_at  TIMESTAMP DEFAULT NOW()
);

-- Table centrale pour les leçons et les énoncés d'exercices
CREATE TABLE supports_cours (
    id                SERIAL PRIMARY KEY,
    affectation_id    INT REFERENCES affectations_enseignement(id) ON DELETE CASCADE,
    type_fichier_id   INT REFERENCES types_fichiers(id) ON DELETE SET NULL,
    titre             VARCHAR(255) NOT NULL,
    description       TEXT,
    fichier_url       VARCHAR(500),          -- Chemin d'accès ou lien cloud du document
    
    -- Nature du document
    type_contenu      VARCHAR(50) DEFAULT 'lecon',    -- 'lecon' | 'exercice' | 'devoir_maison'
    
    -- Gestion des devoirs (applicable si type_contenu != 'lecon')
    date_limite       TIMESTAMP,                      -- Date et heure max pour rendre le travail
    accepte_retard    BOOLEAN DEFAULT FALSE,          -- Autoriser le rendu après la date_limite ?
    
    -- Statut et Traçabilité
    is_archived       BOOLEAN DEFAULT FALSE,          -- Soft delete préféré selon vos conventions
    cree_par          INT REFERENCES users(id) ON DELETE SET NULL, -- Le prof qui publie
    created_at        TIMESTAMP DEFAULT NOW(),
    updated_at        TIMESTAMP DEFAULT NOW()
);


-- ============================================================
-- INDEX DE PERFORMANCE POUR CETTE SECTION
-- ============================================================

CREATE INDEX idx_supports_affectation    ON supports_cours(affectation_id);
CREATE INDEX idx_supports_type_contenu   ON supports_cours(type_contenu);
CREATE INDEX idx_supports_date_limite    ON supports_cours(date_limite) WHERE date_limite IS NOT NULL;

-- ============================================================
-- SEED DE DÉPART (DONNÉES INITIALES)
-- ============================================================

INSERT INTO types_fichiers (libelle) VALUES
    ('Document PDF'),
    ('Document Word (Docx)'),
    ('Feuille de calcul Excel'),
    ('Présentation (PPTX)'),
    ('Lien Externe (Vidéo/Site Web)'),
    ('Archive compressée (ZIP/RAR)');