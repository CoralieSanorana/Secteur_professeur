<?php
  $pageTitle = 'Corps Professoral';
  $activePage = 'dir-professeurs';
  $activeRole = 'directeur';
  $userName = 'M. Rakoto';
  $userRole = 'Directeur';
  $userInitials = 'DR';
?>

<?= view('inc/header',['pageTitle' => $pageTitle, 'activePage' => $activePage]) ?>

    <section class="page-section active" id="dir-professeurs">
      <div class="page-header">
        <div><h2>Corps Professoral</h2><p>24 professeurs actifs dans l'établissement</p></div>
        <button class="btn btn-primary" onclick="openModal('modal-add-prof')"><i class="fas fa-plus"></i> Nouveau professeur</button>
      </div>

      <div class="filter-pills" style="margin-bottom:var(--sp-xl);">
        <div class="pill active">Tous</div>
        <div class="pill">Maths</div>
        <div class="pill">Français</div>
        <div class="pill">Sciences</div>
        <div class="pill">Histoire</div>
        <div class="pill">SVT</div>
        <div class="pill">Anglais</div>
      </div>

      <div class="grid-auto">
        <div class="prof-card" onclick="window.location.href='<?= base_url('directeur/profil_prof') ?>'">
          <div class="prof-card-avatar" style="background:linear-gradient(135deg,var(--clr-navy),var(--clr-violet));">RB</div>
          <h4>Prof. Rabe Hery</h4>
          <div class="matiere">Mathématiques</div>
          <div style="display:flex;justify-content:center;gap:var(--sp-sm);flex-wrap:wrap;margin-top:var(--sp-sm);">
            <span class="badge badge-navy">Terminale C</span>
            <span class="badge badge-navy">1ère C</span>
          </div>
          <div class="salaire">320 000 <span>Ar/mois</span></div>
        </div>
        <div class="prof-card" onclick="window.location.href='<?= base_url('directeur/profil_prof') ?>'">
          <div class="prof-card-avatar" style="background:linear-gradient(135deg,var(--clr-teal),#4ECDC4);">RS</div>
          <h4>Prof. Rasoa Nirina</h4>
          <div class="matiere">Français & Littérature</div>
          <div style="display:flex;justify-content:center;gap:var(--sp-sm);flex-wrap:wrap;margin-top:var(--sp-sm);">
            <span class="badge badge-navy">Seconde A</span>
            <span class="badge badge-navy">1ère A</span>
          </div>
          <div class="salaire">280 000 <span>Ar/mois</span></div>
        </div>
        <div class="prof-card" onclick="window.location.href='<?= base_url('directeur/profil_prof') ?>'">
          <div class="prof-card-avatar" style="background:linear-gradient(135deg,var(--clr-amber),#F5C76A);">AN</div>
          <h4>Prof. Andry Noro</h4>
          <div class="matiere">Sciences Physiques</div>
          <div style="display:flex;justify-content:center;gap:var(--sp-sm);flex-wrap:wrap;margin-top:var(--sp-sm);">
            <span class="badge badge-navy">Terminale D</span>
          </div>
          <div class="salaire">250 000 <span>Ar/mois</span></div>
        </div>
        <div class="prof-card" onclick="window.location.href='<?= base_url('directeur/profil_prof') ?>'">
          <div class="prof-card-avatar" style="background:linear-gradient(135deg,var(--clr-rose),#FF8FA3);">HV</div>
          <h4>Prof. Hery Vatsy</h4>
          <div class="matiere">Histoire-Géographie</div>
          <div style="display:flex;justify-content:center;gap:var(--sp-sm);flex-wrap:wrap;margin-top:var(--sp-sm);">
            <span class="badge badge-navy">Seconde B</span>
            <span class="badge badge-navy">1ère B</span>
          </div>
          <div class="salaire">220 000 <span>Ar/mois</span></div>
        </div>
        <div class="prof-card" onclick="window.location.href='<?= base_url('directeur/profil_prof') ?>'">
          <div class="prof-card-avatar" style="background:linear-gradient(135deg,var(--clr-violet),#A78BFA);">ML</div>
          <h4>Prof. Mamy Lalao</h4>
          <div class="matiere">SVT</div>
          <div style="display:flex;justify-content:center;gap:var(--sp-sm);flex-wrap:wrap;margin-top:var(--sp-sm);">
            <span class="badge badge-navy">Terminale D</span>
            <span class="badge badge-navy">1ère D</span>
          </div>
          <div class="salaire">240 000 <span>Ar/mois</span></div>
        </div>
        <div class="prof-card" onclick="window.location.href='<?= base_url('directeur/profil_prof') ?>'">
          <div class="prof-card-avatar" style="background:linear-gradient(135deg,#059669,#34D399);">JR</div>
          <h4>Prof. Jean Ratsima</h4>
          <div class="matiere">Anglais</div>
          <div style="display:flex;justify-content:center;gap:var(--sp-sm);flex-wrap:wrap;margin-top:var(--sp-sm);">
            <span class="badge badge-navy">Seconde A</span>
            <span class="badge badge-navy">Seconde B</span>
          </div>
          <div class="salaire">200 000 <span>Ar/mois</span></div>
        </div>
      </div>
    </section>

<?= view('inc/modals') ?>

<?= view('inc/footer') ?>