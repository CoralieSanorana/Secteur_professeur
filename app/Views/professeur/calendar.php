<?php
  $pageTitle = 'Emploi du Temps';
  $activePage = 'prof-emploi';
  $activeRole = 'professeur';
  $userName = 'Prof. Rabe';
  $userRole = 'Professeur';
  $userInitials = 'RB';
?>

<?= view('inc/header',['pageTitle' => $pageTitle, 'activePage' => $activePage]) ?>

    <section class="page-section active" id="prof-emploi">
      <div class="page-header">
        <div><h2>Emploi du Temps</h2><p>Semaine du 14 au 18 Avril 2026 — Prof. Rabe Hery</p></div>
        <button class="btn btn-secondary"><i class="fas fa-print"></i> Imprimer</button>
      </div>
      <div class="card">
        <div class="card-body" style="padding:var(--sp-md);">
          <div class="schedule-grid">
            <div class="schedule-header">Heure</div>
            <div class="schedule-header">Lundi</div>
            <div class="schedule-header">Mardi</div>
            <div class="schedule-header">Mercredi</div>
            <div class="schedule-header">Jeudi</div>
            <div class="schedule-header">Vendredi</div>

            <div class="schedule-cell schedule-time">07h–08h</div>
            <div class="schedule-cell"><div class="schedule-class math"><span>Mathématiques</span><small>Terminale C — Salle 8</small></div></div>
            <div class="schedule-cell"></div>
            <div class="schedule-cell"><div class="schedule-class math"><span>Mathématiques</span><small>1ère C — Salle 4</small></div></div>
            <div class="schedule-cell"></div>
            <div class="schedule-cell"><div class="schedule-class math"><span>Mathématiques</span><small>Terminale C — Salle 8</small></div></div>

            <div class="schedule-cell schedule-time">08h–09h</div>
            <div class="schedule-cell"></div>
            <div class="schedule-cell"><div class="schedule-class math"><span>Mathématiques</span><small>Terminale C — Salle 8</small></div></div>
            <div class="schedule-cell"></div>
            <div class="schedule-cell"><div class="schedule-class math"><span>Mathématiques</span><small>1ère C — Salle 4</small></div></div>
            <div class="schedule-cell"></div>

            <div class="schedule-cell schedule-time">09h–10h</div>
            <div class="schedule-cell"></div>
            <div class="schedule-cell"></div>
            <div class="schedule-cell"><div class="schedule-class science"><span>Exercices</span><small>Terminale C — Salle 8</small></div></div>
            <div class="schedule-cell"></div>
            <div class="schedule-cell"></div>

            <div class="schedule-cell schedule-time">10h–11h</div>
            <div class="schedule-cell"><div class="schedule-class math"><span>Mathématiques</span><small>1ère C — Salle 4</small></div></div>
            <div class="schedule-cell"></div>
            <div class="schedule-cell"></div>
            <div class="schedule-cell"><div class="schedule-class math"><span>Mathématiques</span><small>Terminale C — Salle 8</small></div></div>
            <div class="schedule-cell"></div>

            <div class="schedule-cell schedule-time">14h–15h</div>
            <div class="schedule-cell"></div>
            <div class="schedule-cell"><div class="schedule-class science"><span>Exercices</span><small>1ère C — Salle 4</small></div></div>
            <div class="schedule-cell"></div>
            <div class="schedule-cell"></div>
            <div class="schedule-cell"><div class="schedule-class math"><span>Interrogation</span><small>1ère C — Salle 4</small></div></div>
          </div>
        </div>
      </div>
    </section>

<?= view('inc/modals') ?>

<?= view('inc/footer') ?>