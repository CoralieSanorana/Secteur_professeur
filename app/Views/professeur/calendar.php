<?php
  $pageTitle = 'Emploi du Temps';
  $activePage = 'prof-emploi';
  $activeRole = 'professeur';
  $userName = 'Professeur';
  $userRole = 'Professeur';
  $userInitials = 'PR';

  $jours = [
      1 => 'Lundi',
      2 => 'Mardi',
      3 => 'Mercredi',
      4 => 'Jeudi',
      5 => 'Vendredi',
  ];

    $creneaux = [
      ['debut' => '07:00:00', 'fin' => '08:00:00'],
      ['debut' => '08:00:00', 'fin' => '09:00:00'],
      ['debut' => '09:00:00', 'fin' => '10:00:00'],
      ['debut' => '10:00:00', 'fin' => '11:00:00'],
      ['debut' => '14:00:00', 'fin' => '15:00:00'],
        ['debut' => '15:00:00', 'fin' => '16:00:00'],
        ['debut' => '16:00:00', 'fin' => '17:00:00'],
        ['debut' => '17:00:00', 'fin' => '18:00:00'],
    ];

  $formatHeure = static function (?string $heure): string {
      if (!$heure) {
          return '--';
      }

      $timestamp = strtotime($heure);
      return $timestamp !== false ? date('H\hi', $timestamp) : $heure;
  };

  $slugify = static function (string $value): string {
      $value = mb_strtolower(trim($value));
      $value = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value) ?: $value;
      $value = preg_replace('/[^a-z0-9]+/', '-', $value) ?? $value;
      return trim($value, '-') ?: 'cours';
  };

  $emploiDuTemps = $emploiDuTemps ?? [];
  $professeur = $emploiDuTemps[0] ?? null;
  $nomProfesseur = $professeur
      ? trim(($professeur['professeur_prenom'] ?? '') . ' ' . ($professeur['professeur_nom'] ?? ''))
      : 'Professeur';

    if ($nomProfesseur !== 'Professeur') {
      $userName = $nomProfesseur;
      $mots = preg_split('/\s+/', trim($nomProfesseur)) ?: [];
      $initiales = '';
      foreach ($mots as $mot) {
        $initiales .= mb_strtoupper(mb_substr($mot, 0, 1));
      }
      if ($initiales !== '') {
        $userInitials = $initiales;
      }
    }

  $titresParJour = [];
  foreach ($jours as $numero => $label) {
      $titresParJour[$numero] = $label;
  }

    $tranches = [];
    foreach ($creneaux as $creneau) {
      $cle = $creneau['debut'] . '|' . $creneau['fin'];
      $tranches[$cle] = [
        'heure_debut' => $creneau['debut'],
        'heure_fin' => $creneau['fin'],
        'jours' => [],
      ];
    }

    foreach ($emploiDuTemps as $seance) {
      $cle = ($seance['heure_debut'] ?? '') . '|' . ($seance['heure_fin'] ?? '');
      if (!isset($tranches[$cle])) {
        $tranches[$cle] = [
          'heure_debut' => $seance['heure_debut'] ?? null,
          'heure_fin' => $seance['heure_fin'] ?? null,
          'jours' => [],
        ];
      }

      $jour = (int)($seance['jour_semaine'] ?? 0);
      if ($jour >= 1 && $jour <= 5) {
        $tranches[$cle]['jours'][$jour][] = $seance;
      }
  }

  usort($tranches, static function (array $a, array $b): int {
      return strcmp((string)($a['heure_debut'] ?? ''), (string)($b['heure_debut'] ?? ''));
  });
?>

<?= view('inc/header', ['pageTitle' => $pageTitle, 'activePage' => $activePage]) ?>

<section class="page-section active" id="prof-emploi">
  <div class="page-header">
    <div>
      <h2>Emploi du Temps</h2>
      <p>Planning hebdomadaire de <?= esc($nomProfesseur) ?></p>
    </div>
    <button class="btn btn-secondary" type="button" onclick="window.print()">
      <i class="fas fa-print"></i> Imprimer
    </button>
  </div>

  <div class="card">
    <div class="card-body" style="padding:var(--sp-md);">
      <div class="schedule-grid">
        <div class="schedule-header">Heure</div>
        <?php foreach ($jours as $jourLabel) : ?>
          <div class="schedule-header"><?= esc($jourLabel) ?></div>
        <?php endforeach; ?>

        <?php foreach ($tranches as $tranche) : ?>
          <div class="schedule-cell schedule-time">
            <?= esc($formatHeure($tranche['heure_debut'])) ?>–<?= esc($formatHeure($tranche['heure_fin'])) ?>
          </div>

          <?php foreach ($jours as $jourNumero => $jourLabel) : ?>
            <div class="schedule-cell">
              <?php if (!empty($tranche['jours'][$jourNumero])) : ?>
                <?php foreach ($tranche['jours'][$jourNumero] as $seance) : ?>
                  <?php
                    $matiere = trim((string)($seance['matiere_nom'] ?? 'Matière'));
                    $classe = trim((string)($seance['classe_nom'] ?? 'Classe'));
                    $salle = trim((string)($seance['salle_nom'] ?? 'Salle'));
                    $typeClasse = $slugify($matiere);
                  ?>
                  <div class="schedule-class <?= esc($typeClasse) ?>">
                    <span><?= esc($matiere) ?></span>
                    <small><?= esc($classe) ?> — <?= esc($salle) ?></small>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<?= view('inc/modals') ?>

<?= view('inc/footer') ?>
