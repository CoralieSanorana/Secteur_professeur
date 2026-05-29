<?php
namespace App\Models;

use CodeIgniter\Model;

class Notes extends Model
{
    protected $table = 'notes';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['etudiant_id','affectation_id','periode_id','type_evaluation','valeur','sur','commentaire','saisi_par','date_saisie','est_valide','ancienne_valeur','corrige_par','date_correction','motif_correction','created_at','updated_at'];

    public function getNotesByAffectation(int $affectationId, ?int $periodeId = null): array
    {
        $affectation = $this->db->table('affectations_enseignement ae')
            ->select('ae.id, ae.professeur_id, ae.matiere_id, ae.classe_id, ae.annee_scolaire_id, ae.heures_hebdo, ae.created_at')
            ->select('c.nom AS classe_nom')
            ->select('m.nom AS matiere_nom')
            ->select('pp.nom AS professeur_nom, pp.prenom AS professeur_prenom')
            ->select('an.libelle AS annee_scolaire_libelle, an.est_active AS annee_scolaire_active')
            ->join('classes c', 'c.id = ae.classe_id', 'left')
            ->join('matieres m', 'm.id = ae.matiere_id', 'left')
            ->join('profils_professeurs pp', 'pp.id = ae.professeur_id', 'left')
            ->join('annees_scolaires an', 'an.id = ae.annee_scolaire_id', 'left')
            ->where('ae.id', $affectationId)
            ->get()
            ->getRowArray();

        if (!$affectation) {
            return [
                'affectation' => null,
                'students' => [],
                'evaluation_types' => [],
                'notes' => [],
            ];
        }

        $students = $this->db->table('inscriptions i')
            ->select('pe.id AS etudiant_id, pe.matricule, pe.nom, pe.prenom, pe.photo_url')
            ->select('i.id AS inscription_id')
            ->join('profils_etudiants pe', 'pe.id = i.etudiant_id')
            ->where('i.classe_id', $affectation['classe_id'])
            ->where('i.annee_scolaire_id', $affectation['annee_scolaire_id'])
            ->orderBy('pe.nom', 'ASC')
            ->orderBy('pe.prenom', 'ASC')
            ->get()
            ->getResultArray();

        $notesBuilder = $this->db->table('notes n')
            ->select('n.id, n.etudiant_id, n.affectation_id, n.periode_id, n.type_evaluation, n.valeur, n.sur, n.commentaire, n.date_saisie, n.est_valide')
            ->select('p.libelle AS periode_libelle')
            ->join('periodes p', 'p.id = n.periode_id', 'left')
            ->where('n.affectation_id', $affectationId)
            ->orderBy('n.date_saisie', 'DESC')
            ->orderBy('n.id', 'DESC');

        if ($periodeId !== null) {
            $notesBuilder->where('n.periode_id', $periodeId);
        }

        $notes = $notesBuilder->get()->getResultArray();

        $notesByStudent = [];
        $evaluationTypes = [];

        foreach ($notes as $note) {
            $studentId = (int) $note['etudiant_id'];
            $typeEvaluation = (string) ($note['type_evaluation'] ?? '');

            if ($typeEvaluation !== '') {
                $evaluationTypes[$typeEvaluation] = true;
            }

            $notesByStudent[$studentId][$typeEvaluation][] = $note;
        }

        $averages = [];
        foreach ($students as $student) {
            $studentId = (int) $student['etudiant_id'];
            $studentNotes = $notesByStudent[$studentId] ?? [];
            $values = [];

            foreach ($studentNotes as $typeNotes) {
                foreach ($typeNotes as $note) {
                    $sur = (float) ($note['sur'] ?? 20);
                    if ($sur <= 0) {
                        continue;
                    }

                    $values[] = ((float) ($note['valeur'] ?? 0) / $sur) * 20;
                }
            }

            $averages[$studentId] = !empty($values) ? round(array_sum($values) / count($values), 2) : null;
        }

        $ranking = $averages;
        uasort($ranking, static function ($left, $right): int {
            if ($left === $right) {
                return 0;
            }

            if ($left === null) {
                return 1;
            }

            if ($right === null) {
                return -1;
            }

            return $left < $right ? 1 : -1;
        });

        $rankByStudent = [];
        $rank = 1;
        foreach ($ranking as $studentId => $average) {
            $rankByStudent[(int) $studentId] = $average === null ? null : $rank++;
        }

        $studentsWithNotes = [];
        foreach ($students as $student) {
            $studentId = (int) $student['etudiant_id'];
            $studentNotes = $notesByStudent[$studentId] ?? [];
            $latestByType = [];

            foreach ($studentNotes as $typeEvaluation => $typeNotes) {
                $latestByType[$typeEvaluation] = $typeNotes[0] ?? null;
            }

            $studentsWithNotes[] = [
                'etudiant_id' => $studentId,
                'matricule' => $student['matricule'] ?? '',
                'nom' => $student['nom'] ?? '',
                'prenom' => $student['prenom'] ?? '',
                'photo_url' => $student['photo_url'] ?? null,
                'notes_by_type' => $studentNotes,
                'latest_notes_by_type' => $latestByType,
                'moyenne' => $averages[$studentId] ?? null,
                'rang' => $rankByStudent[$studentId] ?? null,
            ];
        }

        return [
            'affectation' => $affectation,
            'students' => $studentsWithNotes,
            'evaluation_types' => array_keys($evaluationTypes),
            'notes' => $notes,
        ];
    }
}
