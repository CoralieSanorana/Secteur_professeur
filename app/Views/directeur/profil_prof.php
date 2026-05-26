<?php
  $pageTitle = 'Profil du Professeur';
  $activePage = 'dir-prof-profil';
  $activeRole = 'directeur';
  $userName = 'M. Rakoto';
  $userRole = 'Directeur';
  $userInitials = 'DR';
?>

<?= view('inc/header',['pageTitle' => $pageTitle, 'activePage' => $activePage]) ?>

    <section class="page-section active" id="dir-prof-profil">
      <div class="page-header">
        <div><h2>Profil du Professeur</h2><p><span style="cursor:pointer;color:var(--clr-amber);" onclick="window.location.href='<?= base_url('directeur/professeurs') ?>'">← Retour à la liste</span></p></div>
        <button class="btn btn-secondary"><i class="fas fa-edit"></i> Modifier</button>
      </div>
      <div class="grid-2">
        <div class="card">
          <div class="card-body" style="text-align:center;padding:var(--sp-2xl);">
            <div class="prof-card-avatar" style="background:linear-gradient(135deg,var(--clr-navy),var(--clr-violet));width:100px;height:100px;font-size:36px;margin:0 auto var(--sp-lg);">RB</div>
            <h3 style="font-family:var(--font-display);font-size:22px;">Prof. Rabe Hery</h3>
            <div style="color:var(--clr-amber);font-weight:600;font-size:14px;margin:var(--sp-sm) 0;">Mathématiques</div>
            <div style="display:flex;justify-content:center;gap:var(--sp-sm);margin-top:var(--sp-sm);">
              <span class="badge badge-green">Actif</span>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header"><h3>Informations</h3></div>
          <div class="card-body">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--sp-md);">
              <div><div style="font-size:11px;text-transform:uppercase;letter-spacing:.8px;color:var(--clr-text-muted);margin-bottom:4px;">Date d'embauche</div><strong>15 Septembre 2020</strong></div>
              <div><div style="font-size:11px;text-transform:uppercase;letter-spacing:.8px;color:var(--clr-text-muted);margin-bottom:4px;">Quartier</div><strong>Analakely</strong></div>
              <div><div style="font-size:11px;text-transform:uppercase;letter-spacing:.8px;color:var(--clr-text-muted);margin-bottom:4px;">Contact</div><strong>034 12 345 67</strong></div>
              <div><div style="font-size:11px;text-transform:uppercase;letter-spacing:.8px;color:var(--clr-text-muted);margin-bottom:4px;">Email</div><strong>rabe@lycee.mg</strong></div>
              <div><div style="font-size:11px;text-transform:uppercase;letter-spacing:.8px;color:var(--clr-text-muted);margin-bottom:4px;">Heures/semaine</div><strong>18 heures</strong></div>
              <div><div style="font-size:11px;text-transform:uppercase;letter-spacing:.8px;color:var(--clr-text-muted);margin-bottom:4px;">Salaire</div><strong style="color:var(--clr-teal);">320 000 Ar</strong></div>
            </div>
          </div>
        </div>
      </div>
      <div class="card" style="margin-top:var(--sp-xl);">
        <div class="card-header"><h3>Présences du mois</h3></div>
        <div class="card-body">
          <div style="display:flex;gap:var(--sp-sm);flex-wrap:wrap;">
            <span style="display:flex;align-items:center;gap:6px;font-size:13px;"><span class="presence-dot present"></span>Présent — 18 jours</span>
            <span style="display:flex;align-items:center;gap:6px;font-size:13px;"><span class="presence-dot absent"></span>Absent — 1 jour</span>
            <span style="display:flex;align-items:center;gap:6px;font-size:13px;"><span class="presence-dot late"></span>Retard — 2 jours</span>
          </div>
          <div style="margin-top:var(--sp-lg);">
            <div class="progress-bar" style="height:12px;">
              <div class="progress-fill teal" style="width:86%;"></div>
            </div>
            <div style="font-size:12px;color:var(--clr-text-muted);margin-top:6px;">Taux de présence: 86%</div>
          </div>
        </div>
      </div>
    </section>

<?= view('inc/modals') ?>

<?= view('inc/footer') ?>