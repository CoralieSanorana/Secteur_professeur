<?php
  $pageTitle = 'Devoirs & Leçons';
  $activePage = 'prof-devoirs';
  $activeRole = 'professeur';
  $userName = 'Prof. Rabe';
  $userRole = 'Professeur';
  $userInitials = 'RB';

  $supportCours = $supportCours ?? [];
  $classes = $classes ?? [];
  $typesFichiers = $typesFichiers ?? [];
  $affectations = $affectations ?? [];
  $matieres = $matieres ?? [];
  $flashSuccess = session()->getFlashdata('success');
  $flashError = session()->getFlashdata('error');
  $showPublishForm = !empty($flashSuccess) || !empty($flashError) || old('titre') !== null;

  $formatDate = static function (?string $dateTime): string {
      if (!$dateTime) {
          return 'Non précisée';
      }

      $timestamp = strtotime($dateTime);
      if ($timestamp === false) {
          return $dateTime;
      }

      return date('d F Y', $timestamp);
  };

  $typeBadgeClass = static function (string $typeContenu): string {
      return match ($typeContenu) {
          'exercice' => 'badge-amber',
          'devoir_maison' => 'badge-navy',
          default => 'badge-teal',
      };
  };
?>

<style>
  .flash-message {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 14px 16px;
    border-radius: 14px;
    margin-bottom: var(--sp-md);
    border: 1px solid transparent;
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
    font-weight: 600;
    line-height: 1.5;
  }

  .flash-message i {
    margin-top: 2px;
    font-size: 18px;
    flex: 0 0 auto;
  }

  .flash-message-success {
    background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    color: #065f46;
    border-color: #a7f3d0;
  }

  .flash-message-error {
    background: linear-gradient(135deg, #fef2f2, #fee2e2);
    color: #991b1b;
    border-color: #fecaca;
  }

  .devoir-section-hidden {
    display: none !important;
  }

  .devoir-section-visible {
    display: block !important;
  }

  #devoirs-grid {
    display: block;
    width: 100%;
  }

  #published-supports-panel,
  #publish-course-section {
    width: 100%;
  }

  #published-supports-panel .devoir-card,
  #publish-course-section .card,
  #publish-course-placeholder {
    width: 100%;
  }

  #publish-course-panel {
    width: 100%;
  }
</style>

<?= view('inc/header', ['pageTitle' => $pageTitle, 'activePage' => $activePage]) ?>

<section class="page-section active" id="prof-devoirs">
  <div class="page-header">
    <div>
      <h2>Devoirs & Leçons</h2>
      <p>Publiez des supports de cours, exercices et devoirs avec pièce jointe.</p>
    </div>
    <button class="btn btn-primary" type="button" onclick="togglePublishForm()">
      <i class="fas fa-plus"></i> Publier cours
    </button>
  </div>

  <?php if (!empty($flashSuccess)) : ?>
    <div class="flash-message flash-message-success" role="status" aria-live="polite">
      <i class="fas fa-check-circle"></i>
      <?= esc($flashSuccess) ?>
    </div>
  <?php endif; ?>

  <?php if (!empty($flashError)) : ?>
    <div class="flash-message flash-message-error" role="alert" aria-live="assertive">
      <i class="fas fa-exclamation-triangle"></i>
      <?= esc($flashError) ?>
    </div>
  <?php endif; ?>

  <div id="devoirs-grid">
    <div id="published-supports-panel" class="devoir-section-visible">
      <h4 style="font-family:var(--font-display);font-size:16px;margin-bottom:var(--sp-md);">Supports déjà publiés</h4>

      <?php if (!empty($supportCours)) : ?>
        <div style="display:flex;flex-direction:column;gap:var(--sp-md);">
          <?php foreach ($supportCours as $support) : ?>
            <?php
              $titre = $support['titre'] ?? 'Sans titre';
              $description = $support['description'] ?? '';
              $classeNom = $support['classe_nom'] ?? 'Classe';
              $matiereNom = $support['matiere_nom'] ?? 'Matière';
              $typeContenu = $support['type_contenu'] ?? 'lecon';
              $typeFichier = $support['type_fichier_libelle'] ?? 'Fichier';
              $dateLimite = $support['date_limite'] ?? null;
              $fichierUrl = $support['fichier_url'] ?? null;
              $profNom = trim(($support['professeur_prenom'] ?? '') . ' ' . ($support['professeur_nom'] ?? ''));
              $badgeClass = $typeBadgeClass($typeContenu);
            ?>
            <div class="devoir-card">
              <div style="display:flex;justify-content:space-between;gap:var(--sp-md);align-items:flex-start;">
                <div>
                  <h4><?= esc($titre) ?></h4>
                  <div class="due">📅 <?= $typeContenu === 'lecon' ? 'Publié' : 'À rendre' ?>: <?= esc($formatDate($dateLimite)) ?></div>
                </div>
                <span class="badge <?= esc($badgeClass) ?>"><?= esc(ucfirst(str_replace('_', ' ', $typeContenu))) ?></span>
              </div>

              <?php if (!empty($description)) : ?>
                <p><?= esc($description) ?></p>
              <?php endif; ?>

              <div style="margin-top:var(--sp-md);display:flex;gap:var(--sp-sm);flex-wrap:wrap;">
                <span class="badge badge-navy"><?= esc($classeNom) ?></span>
                <span class="badge badge-amber"><?= esc($matiereNom) ?></span>
                <span class="badge badge-teal"><?= esc($typeFichier) ?></span>
                <?php if (!empty($profNom)) : ?>
                  <span class="badge" style="background:#eef2ff;color:#3b3b7a;"><?= esc($profNom) ?></span>
                <?php endif; ?>
              </div>

              <?php if (!empty($fichierUrl)) : ?>
                <div style="margin-top:var(--sp-sm);">
                  <a href="<?= esc(base_url($fichierUrl)) ?>" target="_blank" rel="noopener noreferrer">Voir le fichier joint</a>
                </div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else : ?>
        <div class="card">
          <div class="card-body">
            <p style="margin:0;color:var(--clr-text-muted);">Aucun support de cours n’a encore été publié.</p>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <div id="publish-course-section" class="devoir-section-hidden">
      <h4 style="font-family:var(--font-display);font-size:16px;margin-bottom:var(--sp-md);">Publier un cours</h4>
      <div class="card" id="publish-course-panel" style="display:<?= $showPublishForm ? 'block' : 'none' ?>;">
        <div class="card-body">
          <div style="display:flex;justify-content:flex-end;margin-bottom:var(--sp-md);">
            <button class="btn btn-secondary" type="button" onclick="showSupportsList()">
              <i class="fas fa-arrow-left"></i> Retour à la liste
            </button>
          </div>
          <form action="<?= esc(base_url('professeur/supports-cours/publier')) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="form-group">
              <label>Support lié à une affectation</label>
              <select class="form-control" name="affectation_id" required>
                <option value="">-- Choisir une classe / matière --</option>
                <?php foreach ($affectations as $affectation) : ?>
                  <option value="<?= esc($affectation['id']) ?>">
                    <?= esc(($affectation['classe_nom'] ?? 'Classe') . ' - ' . ($affectation['matiere_nom'] ?? 'Matière') . ' - ' . trim(($affectation['professeur_prenom'] ?? '') . ' ' . ($affectation['professeur_nom'] ?? ''))) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>Type de fichier</label>
                <select class="form-control" name="type_fichier_id">
                  <option value="">-- Aucun --</option>
                  <?php foreach ($typesFichiers as $typeFichier) : ?>
                    <option value="<?= esc($typeFichier['id']) ?>"><?= esc($typeFichier['libelle']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label>Type de contenu</label>
                <select class="form-control" name="type_contenu" required>
                  <option value="lecon">Leçon</option>
                  <option value="exercice">Exercice</option>
                  <option value="devoir_maison">Devoir maison</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label>Titre</label>
              <input type="text" class="form-control" name="titre" placeholder="Ex: Exercices sur les suites" required />
            </div>

            <div class="form-group">
              <label>Description</label>
              <textarea class="form-control" name="description" rows="4" placeholder="Instructions détaillées…" style="resize:vertical;"></textarea>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>Date limite</label>
                <input type="datetime-local" class="form-control" name="date_limite" />
              </div>
              <div class="form-group">
                <label>Pièce jointe</label>
                <input type="file" class="form-control" name="fichier" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.rar,.txt,.mp4,.mp3" />
              </div>
            </div>

            <div class="form-group" style="margin-bottom:var(--sp-md);">
              <label style="display:flex;align-items:center;gap:var(--sp-sm);">
                <input type="checkbox" name="accepte_retard" value="1" />
                Accepter les rendus en retard
              </label>
            </div>

            <button class="btn btn-primary" style="width:100%;" type="submit">
              <i class="fas fa-paper-plane"></i> Publier
            </button>
          </form>
        </div>
      </div>

      <div class="card" id="publish-course-placeholder">
        <div class="card-body" style="display:flex;flex-direction:column;gap:var(--sp-sm);">
          <p style="margin:0;color:var(--clr-text-muted);">Clique sur <strong>Publier cours</strong> pour afficher le formulaire de publication.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  function togglePublishForm() {
    const panel = document.getElementById('publish-course-panel');
    const placeholder = document.getElementById('publish-course-placeholder');
    const publishedPanel = document.getElementById('published-supports-panel');
    const publishSection = document.getElementById('publish-course-section');
    if (!panel || !placeholder) return;

    const isHidden = panel.style.display === 'none' || panel.style.display === '';
    panel.style.display = isHidden ? 'block' : 'none';
    placeholder.style.display = isHidden ? 'none' : 'block';

    if (publishedPanel) {
      publishedPanel.classList.toggle('devoir-section-hidden', isHidden);
      publishedPanel.classList.toggle('devoir-section-visible', !isHidden);
    }

    if (publishSection) {
      publishSection.classList.toggle('devoir-section-hidden', !isHidden);
      publishSection.classList.toggle('devoir-section-visible', isHidden);
    }
  }

  function showSupportsList() {
    const panel = document.getElementById('publish-course-panel');
    const placeholder = document.getElementById('publish-course-placeholder');
    const publishedPanel = document.getElementById('published-supports-panel');
    const publishSection = document.getElementById('publish-course-section');

    if (panel) panel.style.display = 'none';
    if (placeholder) placeholder.style.display = 'block';

    if (publishedPanel) {
      publishedPanel.classList.remove('devoir-section-hidden');
      publishedPanel.classList.add('devoir-section-visible');
    }

    if (publishSection) {
      publishSection.classList.add('devoir-section-hidden');
      publishSection.classList.remove('devoir-section-visible');
    }
  }
</script>

<?= view('inc/modals') ?>

<?= view('inc/footer') ?>