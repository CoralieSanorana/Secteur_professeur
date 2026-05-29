<?php
  $pageTitle = 'Notes des Élèves';
  $activePage = 'prof-notes';
  $activeRole = 'professeur';
  $userName = 'Prof. Rabe';
  $userRole = 'Professeur';
  $userInitials = 'RB';

  $affectations = $affectations ?? [];
  $selectedAffectationId = isset($selectedAffectationId) ? (int) $selectedAffectationId : null;
  $selectedPeriodeId = isset($selectedPeriodeId) ? (int) $selectedPeriodeId : null;
  $periodes = $periodes ?? [];
  $noteData = $noteData ?? ['affectation' => null, 'students' => [], 'evaluation_types' => [], 'notes' => []];
  $selectedAffectation = null;

  foreach ($affectations as $affectation) {
    if ((int) ($affectation['id'] ?? 0) === $selectedAffectationId) {
      $selectedAffectation = $affectation;
      break;
    }
  }

  if ($selectedAffectation === null && !empty($noteData['affectation'])) {
    $selectedAffectation = $noteData['affectation'];
  }

  $students = $noteData['students'] ?? [];
  $evaluationTypes = $noteData['evaluation_types'] ?? [];

  $buildUrl = static function (?int $affectationId, ?int $periodeId) : string {
    $query = [];

    if ($affectationId !== null) {
      $query['affectation_id'] = $affectationId;
    }

    if ($periodeId !== null) {
      $query['periode_id'] = $periodeId;
    }

    $queryString = http_build_query($query);

    return $queryString !== '' ? base_url('professeur/notes') . '?' . $queryString : base_url('professeur/notes');
  };

  $formatGrade = static function (?float $value, ?float $sur = 20): string {
    if ($value === null) {
      return '--';
    }

    $sur = $sur && $sur > 0 ? $sur : 20;

    return rtrim(rtrim(number_format($value, 2, '.', ''), '0'), '.') . ' / ' . rtrim(rtrim(number_format($sur, 2, '.', ''), '0'), '.');
  };

  $gradeClass = static function (?float $average): string {
    if ($average === null) {
      return 'grade-average';
    }

    if ($average >= 15) {
      return 'grade-excellent';
    }

    if ($average >= 12) {
      return 'grade-good';
    }

    return 'grade-fail';
  };
?>
    
<?= view('inc/header',['pageTitle' => $pageTitle, 'activePage' => $activePage]) ?>

    <section class="page-section active" id="prof-notes">
      <div class="page-header">
        <div>
          <h2>Notes des Élèves</h2>
          <p>Saisie et suivi des notes par affectation</p>
        </div>
        <div class="page-header-actions">
          <select class="form-control" style="width:auto;padding:8px 12px;" onchange="window.location.href=this.value;">
            <?php foreach ($periodes as $periode) : ?>
              <option value="<?= esc($buildUrl($selectedAffectationId, (int) ($periode['id'] ?? 0))) ?>" <?= (int) ($periode['id'] ?? 0) === $selectedPeriodeId ? 'selected' : '' ?>>
                <?= esc($periode['libelle'] ?? 'Période') ?>
              </option>
            <?php endforeach; ?>
          </select>
          <a class="btn btn-primary" href="<?= esc($selectedAffectationId !== null ? $buildUrl($selectedAffectationId, $selectedPeriodeId) . '#notes-table' : '#notes-table') ?>">
            <i class="fas fa-save"></i> Saisir les notes
          </a>
        </div>
      </div>

      <div class="card" style="margin-bottom:var(--sp-md);">
        <div class="card-body" style="display:flex;flex-direction:column;gap:var(--sp-md);">
          <div style="display:flex;flex-wrap:wrap;gap:var(--sp-sm);">
            <?php foreach ($affectations as $affectation) : ?>
              <?php
                $isActive = (int) ($affectation['id'] ?? 0) === $selectedAffectationId;
                $label = trim(($affectation['classe_nom'] ?? 'Classe') . ' - ' . ($affectation['matiere_nom'] ?? 'Matière'));
                $yearLabel = $affectation['annee_scolaire_libelle'] ?? '';
              ?>
              <a href="<?= esc($buildUrl((int) ($affectation['id'] ?? 0), $selectedPeriodeId)) ?>" class="badge" style="display:inline-flex;flex-direction:column;gap:2px;padding:12px 16px;border-radius:14px;text-decoration:none;background:<?= $isActive ? 'var(--clr-navy)' : '#eef2ff' ?>;color:<?= $isActive ? '#fff' : 'var(--clr-navy)' ?>;border:1px solid <?= $isActive ? 'var(--clr-navy)' : '#d7def8' ?>;min-width:180px;">
                <strong style="font-size:13px;"><?= esc($label) ?></strong>
                <span style="font-size:11px;opacity:.85;"><?= esc(trim(($affectation['professeur_prenom'] ?? '') . ' ' . ($affectation['professeur_nom'] ?? ''))) ?></span>
                <?php if ($yearLabel !== '') : ?>
                  <small style="font-size:10px;opacity:.75;"><?= esc($yearLabel) ?></small>
                <?php endif; ?>
              </a>
            <?php endforeach; ?>
          </div>

          <?php if ($selectedAffectation !== null) : ?>
            <div style="display:flex;flex-wrap:wrap;gap:var(--sp-sm);align-items:center;justify-content:space-between;">
              <div>
                <h4 style="margin:0 0 4px 0;"><?= esc(($selectedAffectation['classe_nom'] ?? 'Classe') . ' - ' . ($selectedAffectation['matiere_nom'] ?? 'Matière')) ?></h4>
                <p style="margin:0;color:var(--clr-text-muted);">
                  <?= esc(trim(($selectedAffectation['professeur_prenom'] ?? '') . ' ' . ($selectedAffectation['professeur_nom'] ?? ''))) ?>
                  <?php if (!empty($selectedAffectation['annee_scolaire_libelle'])) : ?>
                    · <?= esc($selectedAffectation['annee_scolaire_libelle']) ?>
                  <?php endif; ?>
                </p>
              </div>
              <div style="display:flex;gap:var(--sp-sm);flex-wrap:wrap;">
                <span class="badge badge-navy"><?= esc($selectedAffectation['classe_nom'] ?? 'Classe') ?></span>
                <span class="badge badge-amber"><?= esc($selectedAffectation['matiere_nom'] ?? 'Matière') ?></span>
                <?php if (!empty($selectedAffectation['heures_hebdo'])) : ?>
                  <span class="badge badge-teal"><?= esc($selectedAffectation['heures_hebdo']) ?> h / sem.</span>
                <?php endif; ?>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <div class="card" id="notes-table">
        <div class="table-wrapper">
          <?php if (!empty($students)) : ?>
            <table>
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Matricule</th>
                  <th>Nom + Prénom</th>
                  <?php foreach ($evaluationTypes as $evaluationType) : ?>
                    <th><?= esc($evaluationType) ?></th>
                  <?php endforeach; ?>
                  <th>Moyenne</th>
                  <th>Rang</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($students as $student) : ?>
                  <tr>
                    <td><?= esc($student['etudiant_id'] ?? '') ?></td>
                    <td><?= esc($student['matricule'] ?? '') ?></td>
                    <td><?= esc(trim(($student['nom'] ?? '') . ' ' . ($student['prenom'] ?? ''))) ?></td>
                    <?php foreach ($evaluationTypes as $evaluationType) : ?>
                      <?php $latestNote = $student['latest_notes_by_type'][$evaluationType] ?? null; ?>
                      <td>
                        <?php if ($latestNote !== null) : ?>
                          <div class="<?= esc($gradeClass((float) ($latestNote['valeur'] ?? 0))) ?>" style="display:inline-flex;flex-direction:column;gap:2px;min-width:72px;padding:6px 10px;border-radius:10px;">
                            <strong><?= esc($formatGrade((float) ($latestNote['valeur'] ?? 0), (float) ($latestNote['sur'] ?? 20))) ?></strong>
                            <?php if (!empty($student['notes_by_type'][$evaluationType]) && count($student['notes_by_type'][$evaluationType]) > 1) : ?>
                              <small style="font-size:10px;opacity:.8;">+<?= esc(count($student['notes_by_type'][$evaluationType]) - 1) ?> autre(s)</small>
                            <?php endif; ?>
                          </div>
                        <?php else : ?>
                          <span style="color:var(--clr-text-muted);">—</span>
                        <?php endif; ?>
                      </td>
                    <?php endforeach; ?>
                    <td class="<?= esc($gradeClass(isset($student['moyenne']) ? (float) $student['moyenne'] : null)) ?>">
                      <?= esc($student['moyenne'] !== null ? number_format((float) $student['moyenne'], 2, '.', '') : '--') ?>
                    </td>
                    <td>
                      <?php if (!empty($student['rang'])) : ?>
                        <strong style="color:var(--clr-amber);"><?= esc($student['rang']) ?><?= ((int) $student['rang'] === 1) ? 'er' : 'ème' ?></strong>
                      <?php else : ?>
                        <span style="color:var(--clr-text-muted);">—</span>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php else : ?>
            <div class="card-body">
              <p style="margin:0;color:var(--clr-text-muted);">Aucune donnée de notes n’est disponible pour cette affectation.</p>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </section>

<?= view('inc/modals') ?>

<?= view('inc/footer') ?>