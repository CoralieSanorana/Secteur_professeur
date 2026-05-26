<?php
  $pageTitle = 'Mon Profil';
  $activePage = 'prof-profil';
  $activeRole = 'professeur';
  $userName = 'Prof. Rabe';
  $userRole = 'Professeur';
  $userInitials = 'RB';
?>

<?= view('inc/header',['pageTitle' => $pageTitle, 'activePage' => $activePage]) ?>

    <section class="page-section active" id="prof-profil">
      <div class="page-header"><div><h2>Mon Profil</h2><p>Informations personnelles et professionnelles</p></div></div>
      <div class="grid-2">
        <div class="card">
          <div class="card-body" style="text-align:center;padding:var(--sp-2xl);">
            <div class="prof-card-avatar" style="background:linear-gradient(135deg,var(--clr-navy),var(--clr-violet));width:100px;height:100px;font-size:36px;margin:0 auto var(--sp-lg);">RB</div>
            <h3 style="font-family:var(--font-display);font-size:22px;">Prof. Rabe Hery</h3>
            <div style="color:var(--clr-amber);font-weight:600;font-size:13px;margin-top:6px;text-transform:uppercase;letter-spacing:.5px;">Mathématiques</div>
            <div style="margin-top:var(--sp-lg);font-family:var(--font-mono);font-size:22px;color:var(--clr-navy);">320 000 <span style="font-size:13px;font-family:var(--font-body);color:var(--clr-text-muted);">Ar/mois</span></div>
          </div>
        </div>
        <div class="card">
          <div class="card-header"><h3>Mes informations</h3></div>
          <div class="card-body">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--sp-md);">
              <div><div style="font-size:11px;text-transform:uppercase;letter-spacing:.8px;color:var(--clr-text-muted);margin-bottom:4px;">Quartier</div><strong>Analakely</strong></div>
              <div><div style="font-size:11px;text-transform:uppercase;letter-spacing:.8px;color:var(--clr-text-muted);margin-bottom:4px;">Contact</div><strong>034 12 345 67</strong></div>
              <div><div style="font-size:11px;text-transform:uppercase;letter-spacing:.8px;color:var(--clr-text-muted);margin-bottom:4px;">Date d'embauche</div><strong>15 Sept. 2020</strong></div>
              <div><div style="font-size:11px;text-transform:uppercase;letter-spacing:.8px;color:var(--clr-text-muted);margin-bottom:4px;">Titulaire de</div><strong>Terminale C</strong></div>
              <div style="grid-column:span 2;"><div style="font-size:11px;text-transform:uppercase;letter-spacing:.8px;color:var(--clr-text-muted);margin-bottom:4px;">Matières enseignées</div><div style="display:flex;gap:6px;flex-wrap:wrap;margin-top:6px;"><span class="badge badge-amber">Mathématiques</span><span class="badge badge-violet">Statistiques</span></div></div>
            </div>
          </div>
        </div>
      </div>
    </section>

<?= view('inc/modals') ?>

<?= view('inc/footer') ?>