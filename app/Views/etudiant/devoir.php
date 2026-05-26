<?php
  $pageTitle = 'Devoirs & Leçons';
  $activePage = 'etu-devoirs';
  $activeRole = 'etudiant';
  $userName = 'Rakoto Jean';
  $userRole = 'Étudiant';
  $userInitials = 'RJ';
?>

<?= view('inc/header',['pageTitle' => $pageTitle, 'activePage' => $activePage]) ?>

    <section class="page-section active" id="etu-devoirs">
      <div class="page-header">
        <div><h2>Devoirs & Leçons</h2><p>Travaux publiés par vos professeurs</p></div>
      </div>
      <div style="display:flex;flex-direction:column;gap:var(--sp-md);">
        <div class="devoir-card">
          <h4>Exercices — Limites et Continuité</h4>
          <div class="due">📅 À rendre: 18 Avril 2026</div>
          <p>Exercices 5 à 12 page 87 du manuel. Correction de l'exercice 4 vue en classe.</p>
          <div style="margin-top:var(--sp-md);display:flex;gap:var(--sp-sm);">
            <span class="badge badge-amber">Mathématiques</span>
            <span class="badge badge-red">Dans 2 jours</span>
          </div>
        </div>
        <div class="devoir-card" style="border-left-color:var(--clr-teal);">
          <h4>Leçon — Génétique et Hérédité</h4>
          <div class="due" style="color:var(--clr-teal);">📅 Pour: 21 Avril 2026</div>
          <p>Relire le chapitre 8 de SVT. Mémoriser les lois de Mendel.</p>
          <div style="margin-top:var(--sp-md);display:flex;gap:var(--sp-sm);">
            <span class="badge badge-violet">SVT</span>
            <span class="badge badge-green">Dans 5 jours</span>
          </div>
        </div>
        <div class="devoir-card" style="border-left-color:var(--clr-violet);">
          <h4>Dissertation — La Négritude</h4>
          <div class="due" style="color:var(--clr-violet);">📅 À rendre: 25 Avril 2026</div>
          <p>Rédiger une dissertation de 3 pages sur le mouvement de la Négritude. Plan détaillé obligatoire.</p>
          <div style="margin-top:var(--sp-md);display:flex;gap:var(--sp-sm);">
            <span class="badge badge-navy">Français</span>
            <span class="badge badge-green">Dans 9 jours</span>
          </div>
        </div>
      </div>
    </section>

<?= view('inc/modals') ?>

<?= view('inc/footer') ?>