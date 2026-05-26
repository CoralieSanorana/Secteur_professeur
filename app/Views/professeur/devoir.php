<?php
  $pageTitle = 'Devoirs & Leçons';
  $activePage = 'prof-devoirs';
  $activeRole = 'professeur';
  $userName = 'Prof. Rabe';
  $userRole = 'Professeur';
  $userInitials = 'RB';
?>

<?= view('inc/header',['pageTitle' => $pageTitle, 'activePage' => $activePage]) ?>

    <section class="page-section active" id="prof-devoirs">
      <div class="page-header">
        <div><h2>Devoirs & Leçons</h2><p>Publier des devoirs pour vos classes</p></div>
        <button class="btn btn-primary" onclick="openModal('modal-devoir')"><i class="fas fa-plus"></i> Nouveau devoir</button>
      </div>
      <div class="grid-2">
        <div>
          <h4 style="font-family:var(--font-display);font-size:16px;margin-bottom:var(--sp-md);">Devoirs publiés</h4>
          <div style="display:flex;flex-direction:column;gap:var(--sp-md);">
            <div class="devoir-card">
              <h4>Exercices — Limites et Continuité</h4>
              <div class="due">📅 À rendre: 18 Avril 2026</div>
              <p>Exercices 5 à 12 page 87 du manuel. Correction de l'exercice 4 vue en classe.</p>
              <div style="margin-top:var(--sp-md);display:flex;gap:var(--sp-sm);">
                <span class="badge badge-navy">Terminale C</span>
                <span class="badge badge-amber">Mathématiques</span>
              </div>
            </div>
            <div class="devoir-card" style="border-left-color:var(--clr-teal);">
              <h4>Leçon à apprendre — Dérivées</h4>
              <div class="due" style="color:var(--clr-teal);">📅 Pour: 21 Avril 2026</div>
              <p>Relire le chapitre 6 complet. Mémoriser les règles de dérivation.</p>
              <div style="margin-top:var(--sp-md);display:flex;gap:var(--sp-sm);">
                <span class="badge badge-navy">1ère C</span>
                <span class="badge badge-amber">Mathématiques</span>
              </div>
            </div>
          </div>
        </div>
        <div>
          <h4 style="font-family:var(--font-display);font-size:16px;margin-bottom:var(--sp-md);">Nouveau devoir / leçon</h4>
          <div class="card">
            <div class="card-body">
              <div class="form-group">
                <label>Titre</label>
                <input type="text" class="form-control" placeholder="Ex: Exercices sur les suites"/>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label>Classe concernée</label>
                  <select class="form-control">
                    <option>Terminale C</option><option>1ère C</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Date limite</label>
                  <input type="date" class="form-control"/>
                </div>
              </div>
              <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" rows="4" placeholder="Instructions détaillées…" style="resize:vertical;"></textarea>
              </div>
              <button class="btn btn-primary" style="width:100%;" onclick="showToast('📚 Devoir publié !')">
                <i class="fas fa-paper-plane"></i> Publier
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

<?= view('inc/modals') ?>

<?= view('inc/footer') ?>