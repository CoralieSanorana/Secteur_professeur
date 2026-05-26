<?php
  $pageTitle = "Profil de l'Élève";
  $activePage = 'sec-profils';
  $activeRole = 'secretariat';
  $userName = 'Mme. Rasoa';
  $userRole = 'Secrétaire';
  $userInitials = 'RS';
?>

<?= view('inc/header',['pageTitle' => $pageTitle, 'activePage' => $activePage]) ?>

    <section class="page-section active" id="sec-profils">
      <div class="page-header">
        <div><h2>Profil de l'Élève</h2><p><span style="cursor:pointer;color:var(--clr-amber);" onclick="window.location.href='/secretariat/eleves'">← Retour à la liste</span></p></div>
        <button class="btn btn-secondary"><i class="fas fa-print"></i> Imprimer</button>
      </div>
      <div class="grid-2">
        <div class="card">
          <div class="card-body" style="text-align:center;padding:var(--sp-2xl);">
            <div class="avatar-placeholder" style="width:90px;height:90px;background:linear-gradient(135deg,var(--clr-navy),var(--clr-teal));font-size:32px;margin:0 auto var(--sp-lg);">RJ</div>
            <h3 style="font-family:var(--font-display);font-size:22px;">Rakoto Jean</h3>
            <div style="margin-top:var(--sp-sm);"><span class="badge badge-navy">1ère A</span></div>
            <div style="margin-top:var(--sp-lg);font-family:var(--font-mono);font-size:12px;color:var(--clr-text-muted);">ID-2025-0047</div>
          </div>
        </div>
        <div class="card">
          <div class="card-header"><h3>Informations personnelles</h3></div>
          <div class="card-body">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--sp-md);">
              <div><div style="font-size:11px;text-transform:uppercase;letter-spacing:.8px;color:var(--clr-text-muted);margin-bottom:4px;">Date de naissance</div><strong>12 Mars 2009</strong></div>
              <div><div style="font-size:11px;text-transform:uppercase;letter-spacing:.8px;color:var(--clr-text-muted);margin-bottom:4px;">Quartier</div><strong>Tsaralalàna</strong></div>
              <div><div style="font-size:11px;text-transform:uppercase;letter-spacing:.8px;color:var(--clr-text-muted);margin-bottom:4px;">Adresse</div><strong>Lot 24, Tsaralalàna</strong></div>
              <div><div style="font-size:11px;text-transform:uppercase;letter-spacing:.8px;color:var(--clr-text-muted);margin-bottom:4px;">Date d'inscription</div><strong>28 Août 2025</strong></div>
              <div><div style="font-size:11px;text-transform:uppercase;letter-spacing:.8px;color:var(--clr-text-muted);margin-bottom:4px;">Nom du parent</div><strong>Rakoto Pierre</strong></div>
              <div><div style="font-size:11px;text-transform:uppercase;letter-spacing:.8px;color:var(--clr-text-muted);margin-bottom:4px;">Contact parent</div><strong>034 56 789 01</strong></div>
            </div>
          </div>
        </div>
      </div>
      <div class="card" style="margin-top:var(--sp-xl);">
        <div class="card-header"><h3>Historique de paiement</h3></div>
        <div class="table-wrapper">
          <table>
            <thead><tr><th>Mois</th><th>Date de paiement</th><th>Montant</th><th>Statut</th></tr></thead>
            <tbody>
              <tr><td>Janvier 2026</td><td>02/01/2026</td><td>80 000 Ar</td><td><span class="badge badge-green">Payé</span></td></tr>
              <tr><td>Février 2026</td><td>04/02/2026</td><td>80 000 Ar</td><td><span class="badge badge-green">Payé</span></td></tr>
              <tr><td>Mars 2026</td><td>01/03/2026</td><td>80 000 Ar</td><td><span class="badge badge-green">Payé</span></td></tr>
              <tr><td>Avril 2026</td><td>02/04/2026</td><td>80 000 Ar</td><td><span class="badge badge-green">Payé</span></td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

<?= view('inc/modals') ?>

<?= view('inc/footer') ?>