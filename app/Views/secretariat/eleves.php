<?php
  $pageTitle = 'Liste des Élèves';
  $activePage = 'sec-eleves';
  $activeRole = 'secretariat';
  $userName = 'Mme. Rasoa';
  $userRole = 'Secrétaire';
  $userInitials = 'RS';
?>

<?= view('inc/header',['pageTitle' => $pageTitle, 'activePage' => $activePage]) ?>

    <section class="page-section active" id="sec-eleves">
      <div class="page-header">
        <div><h2>Liste des Élèves</h2><p>203 élèves inscrits pour l'année 2025–2026</p></div>
        <button class="btn btn-primary" onclick="openModal('modal-add-eleve')"><i class="fas fa-plus"></i> Nouvel élève</button>
      </div>

      <div style="display:flex;gap:var(--sp-md);margin-bottom:var(--sp-lg);flex-wrap:wrap;align-items:center;">
        <div class="filter-pills">
          <div class="pill active">Tous</div>
          <div class="pill">Seconde</div>
          <div class="pill">1ère</div>
          <div class="pill">Terminale</div>
        </div>
        <div style="display:flex;gap:var(--sp-sm);margin-left:auto;">
          <select class="form-control" style="width:auto;padding:8px 12px;font-size:13px;">
            <option>Toutes les salles</option><option>Seconde A</option><option>Seconde B</option>
            <option>1ère A</option><option>1ère B</option><option>Terminale C</option>
          </select>
          <input type="text" class="form-control" placeholder="Rechercher un élève…" style="width:220px;"/>
        </div>
      </div>

      <div class="card">
        <div class="table-wrapper">
          <table>
            <thead><tr><th>Élève</th><th>Classe</th><th>Janv.</th><th>Fév.</th><th>Mars</th><th>Avr.</th><th>Actions</th></tr></thead>
            <tbody>
              <tr>
                <td><div style="display:flex;align-items:center;gap:var(--sp-md);"><div class="avatar-placeholder" style="width:32px;height:32px;background:linear-gradient(135deg,var(--clr-navy),var(--clr-violet));font-size:12px;">RJ</div>Rakoto Jean</div></td>
                <td><span class="badge badge-navy">1ère A</span></td>
                <td><span class="badge badge-green">✓</span></td>
                <td><span class="badge badge-green">✓</span></td>
                <td><span class="badge badge-green">✓</span></td>
                <td><span class="badge badge-green">✓</span></td>
                <td><button class="btn btn-sm btn-secondary" onclick="window.location.href='/secretariat/profil_eleve'">Profil</button></td>
              </tr>
              <tr>
                <td><div style="display:flex;align-items:center;gap:var(--sp-md);"><div class="avatar-placeholder" style="width:32px;height:32px;background:linear-gradient(135deg,var(--clr-teal),#4ECDC4);font-size:12px;">AM</div>Andria Miora</div></td>
                <td><span class="badge badge-navy">Seconde B</span></td>
                <td><span class="badge badge-green">✓</span></td>
                <td><span class="badge badge-green">✓</span></td>
                <td><span class="badge badge-red">✗</span></td>
                <td><span class="badge badge-green">✓</span></td>
                <td><button class="btn btn-sm btn-secondary" onclick="window.location.href='/secretariat/profil_eleve'">Profil</button></td>
              </tr>
              <tr>
                <td><div style="display:flex;align-items:center;gap:var(--sp-md);"><div class="avatar-placeholder" style="width:32px;height:32px;background:linear-gradient(135deg,var(--clr-amber),#F5C76A);font-size:12px;">HN</div>Hery Njaka</div></td>
                <td><span class="badge badge-navy">1ère B</span></td>
                <td><span class="badge badge-green">✓</span></td>
                <td><span class="badge badge-red">✗</span></td>
                <td><span class="badge badge-red">✗</span></td>
                <td><span class="badge badge-red">✗</span></td>
                <td><button class="btn btn-sm btn-secondary" onclick="window.location.href='/secretariat/profil_eleve'">Profil</button></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

<?= view('inc/modals') ?>

<?= view('inc/footer') ?>