<?php
  $pageTitle = 'Mon Emploi du Temps';
  $activePage = 'etu-emploi';
  $activeRole = 'etudiant';
  $userName = 'Rakoto Jean';
  $userRole = 'Étudiant';
  $userInitials = 'RJ';
?>

<?= view('inc/header',['pageTitle' => $pageTitle, 'activePage' => $activePage]) ?>

    <section class="page-section active" id="etu-emploi">
      <div class="page-header">
        <div><h2>Mon Emploi du Temps</h2><p>Semaine du 14 au 18 Avril 2026 — Terminale C</p></div>
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
            <div class="schedule-cell"><div class="schedule-class math"><span>Mathématiques</span><small>Prof. Rabe</small></div></div>
            <div class="schedule-cell"><div class="schedule-class french"><span>Français</span><small>Prof. Rasoa</small></div></div>
            <div class="schedule-cell"><div class="schedule-class math"><span>Mathématiques</span><small>Prof. Rabe</small></div></div>
            <div class="schedule-cell"><div class="schedule-class history"><span>Histoire-Géo</span><small>Prof. Hery</small></div></div>
            <div class="schedule-cell"><div class="schedule-class math"><span>Mathématiques</span><small>Prof. Rabe</small></div></div>

            <div class="schedule-cell schedule-time">08h–09h</div>
            <div class="schedule-cell"><div class="schedule-class science"><span>Sc. Physiques</span><small>Prof. Andry</small></div></div>
            <div class="schedule-cell"><div class="schedule-class math"><span>Mathématiques</span><small>Prof. Rabe</small></div></div>
            <div class="schedule-cell"><div class="schedule-class french"><span>Français</span><small>Prof. Rasoa</small></div></div>
            <div class="schedule-cell"><div class="schedule-class math"><span>Mathématiques</span><small>Prof. Rabe</small></div></div>
            <div class="schedule-cell"><div class="schedule-class science"><span>SVT</span><small>Prof. Mamy</small></div></div>

            <div class="schedule-cell schedule-time">09h–10h</div>
            <div class="schedule-cell"></div>
            <div class="schedule-cell"><div class="schedule-class history"><span>Histoire-Géo</span><small>Prof. Hery</small></div></div>
            <div class="schedule-cell"><div class="schedule-class science"><span>Sc. Physiques</span><small>Prof. Andry</small></div></div>
            <div class="schedule-cell"><div class="schedule-class french"><span>Français</span><small>Prof. Rasoa</small></div></div>
            <div class="schedule-cell"></div>

            <div class="schedule-cell schedule-time">14h–15h</div>
            <div class="schedule-cell"><div class="schedule-class french"><span>Anglais</span><small>Prof. Jean</small></div></div>
            <div class="schedule-cell"><div class="schedule-class science"><span>SVT</span><small>Prof. Mamy</small></div></div>
            <div class="schedule-cell"></div>
            <div class="schedule-cell"><div class="schedule-class science"><span>Anglais</span><small>Prof. Jean</small></div></div>
            <div class="schedule-cell"><div class="schedule-class math"><span>Interrogation</span><small>Prof. Rabe</small></div></div>
          </div>
        </div>
      </div>
    </section>

<?= view('inc/modals') ?>

<?= view('inc/footer') ?>