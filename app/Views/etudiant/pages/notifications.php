<?php
  $pageTitle = 'Notifications';
  $activePage = 'notifications-page';
  $activeRole = 'directeur';
  $userName = 'M. Rakoto';
  $userRole = 'Directeur';
  $userInitials = 'DR';
?>

<?= view('inc/header',['pageTitle' => $pageTitle, 'activePage' => $activePage]) ?>

    <section class="page-section active" id="notifications-page">
      <div class="page-header">
        <div><h2>Notifications</h2><p>Tous vos événements et alertes</p></div>
        <button class="btn btn-secondary"><i class="fas fa-check-double"></i> Tout marquer lu</button>
      </div>
      <div class="card">
        <div class="notif-item unread">
          <div class="notif-item-icon" style="background:var(--clr-amber-pale);color:var(--clr-amber);">💰</div>
          <div class="notif-item-text" style="flex:1;">
            <strong>Nouveau paiement reçu — Rakoto Jean</strong>
            <small>1ère A — 80 000 Ar — il y a 10 min</small>
          </div>
          <span class="badge badge-amber">Nouveau</span>
        </div>
        <div class="notif-item unread">
          <div class="notif-item-icon" style="background:var(--clr-teal-light);color:var(--clr-teal);">📝</div>
          <div class="notif-item-text" style="flex:1;">
            <strong>Notes publiées — Mathématiques Terminale C</strong>
            <small>Par Prof. Rabe — il y a 30 min</small>
          </div>
          <span class="badge badge-amber">Nouveau</span>
        </div>
        <div class="notif-item">
          <div class="notif-item-icon" style="background:var(--clr-violet-light);color:var(--clr-violet);">📣</div>
          <div class="notif-item-text" style="flex:1;">
            <strong>Réunion parents-profs programmée</strong>
            <small>Vendredi 19 avril 2026 — 9h00</small>
          </div>
        </div>
        <div class="notif-item">
          <div class="notif-item-icon" style="background:var(--clr-rose-light);color:var(--clr-rose);">⚠️</div>
          <div class="notif-item-text" style="flex:1;">
            <strong>3 élèves n'ont pas payé l'écolage d'Avril</strong>
            <small>Action requise — 16 Avril 2026</small>
          </div>
        </div>
        <div class="notif-item">
          <div class="notif-item-icon" style="background:var(--clr-teal-light);color:var(--clr-teal);">🏆</div>
          <div class="notif-item-text" style="flex:1;">
            <strong>Bulletin du Trimestre 2 publié</strong>
            <small>Terminale C — 10 Avril 2026</small>
          </div>
        </div>
      </div>
    </section>

<?= view('inc/modals') ?>

<?= view('inc/footer') ?>