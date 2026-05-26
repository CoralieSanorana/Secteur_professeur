<?php
  $pageTitle = $pageTitle ?? 'Tableau de bord';
  $activePage = $activePage ?? 'dir-dashboard';
  $activeRole = $activeRole ?? 'directeur';
  $userName = $userName ?? 'M. Rakoto';
  $userRole = $userRole ?? 'Directeur';
  $userInitials = $userInitials ?? 'DR';
  $stylePath = FCPATH . 'assets/css/style.css';
  $navActiveClass = static function (string $pageId) use ($activePage): string {
    return $activePage === $pageId ? 'nav-item active' : 'nav-item';
  };
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>LycéePro — <?= esc($pageTitle) ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="/assets/css/style.css">
<?php if (is_file($stylePath)): ?>
  <style>
<?= file_get_contents($stylePath) ?>
  </style>
<?php endif; ?>
</head>
<body data-active-page="<?= esc($activePage) ?>" data-active-role="<?= esc($activeRole) ?>">
<div class="app-shell">

  <!-- SIDEBAR -->
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
      <div class="sidebar-brand-icon">🎓</div>
      <div class="sidebar-brand-text">
        <h1>LycéePro</h1>
        <span>Gestion Scolaire</span>
      </div>
    </div>

    <div class="role-switcher">
      <label>Vue actuelle</label>
      <select id="roleSelect" class="role-select" onchange="switchRole(this.value)">
        <option value="directeur" <?= $activeRole === 'directeur' ? 'selected' : '' ?>>👔 Directeur</option>
        <option value="secretariat" <?= $activeRole === 'secretariat' ? 'selected' : '' ?>>📋 Secrétariat</option>
        <option value="professeur" <?= $activeRole === 'professeur' ? 'selected' : '' ?>>📚 Professeur</option>
        <option value="etudiant" <?= $activeRole === 'etudiant' ? 'selected' : '' ?>>🎒 Étudiant</option>
      </select>
    </div>

    <!-- Directeur nav -->
    <nav class="nav-section" id="nav-directeur" <?= $activeRole !== 'directeur' ? 'style="display:none"' : '' ?>>
      <p class="nav-section-title">Direction</p>
      <a class="<?= $navActiveClass('dir-dashboard') ?>" href="/directeur/dashboard" data-page="dir-dashboard">
        <i class="fas fa-chart-pie"></i> Tableau de bord
      </a>
      <a class="<?= $navActiveClass('dir-finances') ?>" href="/directeur/finance" data-page="dir-finances">
        <i class="fas fa-coins"></i> Finances & Bénéfices
      </a>
      <a class="<?= $navActiveClass('dir-professeurs') ?>" href="/directeur/professeurs" data-page="dir-professeurs">
        <i class="fas fa-chalkboard-teacher"></i> Professeurs
      </a>
      <a class="<?= $navActiveClass('dir-ecolages') ?>" href="/directeur/ecolages" data-page="dir-ecolages">
        <i class="fas fa-receipt"></i> Écolages du mois
      </a>
      <p class="nav-section-title">Général</p>
      <a class="<?= $navActiveClass('actualites') ?>" href="/actualites" data-page="actualites">
        <i class="fas fa-newspaper"></i> Actualités <span class="nav-badge">3</span>
      </a>
      <a class="<?= $navActiveClass('notifications-page') ?>" href="/notifications" data-page="notifications-page">
        <i class="fas fa-bell"></i> Notifications <span class="nav-badge">5</span>
      </a>
    </nav>

    <!-- Secretariat nav -->
    <nav class="nav-section" id="nav-secretariat" style="display:none">
      <p class="nav-section-title">Secrétariat</p>
      <a class="<?= $navActiveClass('sec-paiements') ?>" href="/secretariat/paiement" data-page="sec-paiements">
        <i class="fas fa-plus-circle"></i> Ajouter Paiement
      </a>
      <a class="<?= $navActiveClass('sec-bilan') ?>" href="/secretariat/bilan" data-page="sec-bilan">
        <i class="fas fa-chart-bar"></i> Bilan de paiement
      </a>
      <a class="<?= $navActiveClass('sec-eleves') ?>" href="/secretariat/eleves" data-page="sec-eleves">
        <i class="fas fa-users"></i> Liste des élèves
      </a>
      <a class="<?= $navActiveClass('sec-profils') ?>" href="/secretariat/profil_eleve" data-page="sec-profils">
        <i class="fas fa-id-card"></i> Profils élèves
      </a>
      <p class="nav-section-title">Général</p>
      <a class="<?= $navActiveClass('actualites') ?>" href="/actualites" data-page="actualites">
        <i class="fas fa-newspaper"></i> Actualités <span class="nav-badge">3</span>
      </a>
    </nav>

    <!-- Professeur nav -->
    <nav class="nav-section" id="nav-professeur" style="display:none">
      <p class="nav-section-title">Enseignement</p>
      <a class="<?= $navActiveClass('prof-emploi') ?>" href="/professeur/calendar" data-page="prof-emploi">
        <i class="fas fa-calendar-week"></i> Emploi du temps
      </a>
      <a class="<?= $navActiveClass('prof-notes') ?>" href="/professeur/notes" data-page="prof-notes">
        <i class="fas fa-star"></i> Notes des élèves
      </a>
      <a class="<?= $navActiveClass('prof-devoirs') ?>" href="/professeur/devoirs" data-page="prof-devoirs">
        <i class="fas fa-book-open"></i> Devoirs & Leçons
      </a>
      <a class="<?= $navActiveClass('prof-bulletins') ?>" href="/professeur/bulletin" data-page="prof-bulletins">
        <i class="fas fa-file-alt"></i> Bulletins
      </a>
      <a class="<?= $navActiveClass('prof-profil') ?>" href="/professeur/profil" data-page="prof-profil">
        <i class="fas fa-user-circle"></i> Mon Profil
      </a>
      <p class="nav-section-title">Général</p>
      <a class="<?= $navActiveClass('actualites') ?>" href="/actualites" data-page="actualites">
        <i class="fas fa-newspaper"></i> Actualités
      </a>
    </nav>

    <!-- Etudiant nav -->
    <nav class="nav-section" id="nav-etudiant" style="display:none">
      <p class="nav-section-title">Mon Espace</p>
      <a class="<?= $navActiveClass('etu-emploi') ?>" href="/etudiant/calendar" data-page="etu-emploi">
        <i class="fas fa-calendar-week"></i> Emploi du temps
      </a>
      <a class="<?= $navActiveClass('etu-notes') ?>" href="/etudiant/notes" data-page="etu-notes">
        <i class="fas fa-star"></i> Mes Notes
      </a>
      <a class="<?= $navActiveClass('etu-bulletin') ?>" href="/etudiant/bulletin" data-page="etu-bulletin">
        <i class="fas fa-file-alt"></i> Mon Bulletin
      </a>
      <a class="<?= $navActiveClass('etu-devoirs') ?>" href="/etudiant/devoirs" data-page="etu-devoirs">
        <i class="fas fa-book-open"></i> Devoirs & Leçons
      </a>
      <p class="nav-section-title">Général</p>
      <a class="<?= $navActiveClass('actualites') ?>" href="/actualites" data-page="actualites">
        <i class="fas fa-newspaper"></i> Actualités <span class="nav-badge">2</span>
      </a>
    </nav>

    <div class="sidebar-footer">
      <div class="sidebar-user">
        <div class="sidebar-avatar" id="sidebar-avatar-initials"><?= esc($userInitials) ?></div>
        <div class="sidebar-user-info">
          <strong id="sidebar-user-name"><?= esc($userName) ?></strong>
          <small id="sidebar-user-role"><?= esc($userRole) ?></small>
        </div>
        <i class="fas fa-sign-out-alt" style="color:rgba(255,255,255,.3);font-size:14px;"></i>
      </div>
    </div>
  </aside>

  <!-- TOPBAR -->
  <header class="topbar">
    <div class="topbar-title" id="topbar-title"><?= esc($pageTitle) ?></div>
    <div class="topbar-search">
      <i class="fas fa-search"></i>
      <input type="text" placeholder="Rechercher…"/>
    </div>
    <div class="topbar-actions">
      <button class="topbar-btn" style="position:relative;" onclick="toggleNotif()" type="button">
        <i class="fas fa-bell"></i>
        <span class="notif-dot"></span>
        <div class="notif-dropdown" id="notif-dropdown">
          <div class="notif-dropdown-head">
            <h4>Notifications</h4>
            <span style="font-size:12px;color:var(--clr-amber);cursor:pointer;">Tout lire</span>
          </div>
          <div class="notif-item unread">
            <div class="notif-item-icon" style="background:var(--clr-amber-pale);color:var(--clr-amber);">💰</div>
            <div class="notif-item-text">
              <strong>Nouveau paiement reçu</strong>
              <small>Rakoto Jean — 1ère A — il y a 10 min</small>
            </div>
          </div>
          <div class="notif-item unread">
            <div class="notif-item-icon" style="background:var(--clr-teal-light);color:var(--clr-teal);">📝</div>
            <div class="notif-item-text">
              <strong>Notes publiées — Maths</strong>
              <small>Prof. Rabe — il y a 30 min</small>
            </div>
          </div>
          <div class="notif-item">
            <div class="notif-item-icon" style="background:var(--clr-violet-light);color:var(--clr-violet);">📣</div>
            <div class="notif-item-text">
              <strong>Réunion parents-profs</strong>
              <small>Vendredi 19 avril 2026 — 9h00</small>
            </div>
          </div>
          <div class="notif-item">
            <div class="notif-item-icon" style="background:var(--clr-rose-light);color:var(--clr-rose);">⚠️</div>
            <div class="notif-item-text">
              <strong>3 élèves n'ont pas payé</strong>
              <small>Mois d'Avril — action requise</small>
            </div>
          </div>
        </div>
      </button>
      <button class="topbar-btn" type="button"><i class="fas fa-cog"></i></button>
      <div class="topbar-user" onclick="openModal('modal-profil')">
        <div class="topbar-avatar" id="topbar-avatar-initials"><?= esc($userInitials) ?></div>
        <div class="topbar-user-meta">
          <strong id="topbar-user-name"><?= esc($userName) ?></strong>
          <small id="topbar-user-role"><?= esc($userRole) ?></small>
        </div>
        <i class="fas fa-chevron-down" style="font-size:10px;color:var(--clr-text-muted);"></i>
      </div>
    </div>
  </header>

  <main class="main-content">