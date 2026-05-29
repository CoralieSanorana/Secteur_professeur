<?php
  $pageTitle = $pageTitle ?? 'Gestion des absences';
  $activePage = $activePage ?? 'prof-absences';
  $activeRole = $activeRole ?? 'professeur';
  $userName = $userName ?? 'Professeur';
  $userRole = $userRole ?? 'Professeur';
  $userInitials = $userInitials ?? 'PR';
  
  $etudiants = $etudiants ?? [];
  $absencesMap = $absencesMap ?? [];
  $seanceId = $seanceId ?? '';
  $classeId = $classeId ?? '';
  $classes = $classes ?? [];
?>

<?= view('inc/header', ['pageTitle' => $pageTitle, 'activePage' => $activePage, 'activeRole' => $activeRole, 'userName' => $userName, 'userRole' => $userRole, 'userInitials' => $userInitials]) ?>

    <section class="page-section active" id="prof-absences">
      <div class="page-header">
        <div>
          <h2>Gestion des absences</h2>
          <p>Saisie des présences et absences des élèves</p>
        </div>
      </div>
      
      <!-- Sélecteur de classe -->
      <?php if (!empty($classes)): ?>
      <div class="card" style="margin-bottom:var(--sp-lg);">
        <div class="card-body" style="padding:var(--sp-md);">
          <div style="display:flex; gap:var(--sp-md); align-items:center; flex-wrap:wrap;">
            <label style="font-weight:600;">Classe :</label>
            <select id="classeSelect" class="classe-select" style="padding:8px 12px; border-radius:var(--radius-md); border:1px solid var(--clr-border); background:white;">
              <?php foreach ($classes as $classe): ?>
                <option value="<?= $classe['id'] ?>" <?= $classe['id'] == $classeId ? 'selected' : '' ?>>
                  <?= esc($classe['niveau'] ?? '') ?> - <?= esc($classe['nom']) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <button class="btn btn-primary" onclick="changerClasse()">
              <i class="fas fa-search"></i> Charger
            </button>
            <?php if (!empty($seance)): ?>
            <span class="badge badge-info" style="margin-left:auto;">
              <i class="fas fa-clock"></i> Cours: <?= date('d/m/Y', strtotime($seance['date_seance'])) ?>
            </span>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php endif; ?>
      
      <!-- Formulaire de saisie des absences -->
      <div class="card">
        <div class="card-header">
          <h3>Liste des élèves</h3>
          <button type="button" class="btn btn-primary" onclick="submitAbsences()">
            <i class="fas fa-save"></i> Valider présence
          </button>
        </div>
        <div class="card-body" style="overflow-x:auto;">
          <?php if (empty($etudiants)): ?>
            <div class="alert alert-warning" style="text-align:center; padding:var(--sp-xl);">
              <i class="fas fa-users-slash" style="font-size:48px; opacity:0.5; margin-bottom:var(--sp-md); display:block;"></i>
              Aucun élève inscrit dans cette classe.
            </div>
          <?php else: ?>
            <form id="formAbsences">
              <input type="hidden" name="seance_id" value="<?= $seanceId ?>">
              <input type="hidden" name="classe_id" value="<?= $classeId ?>">
              <table style="width:100%; border-collapse:collapse;">
                <thead>
                  <tr style="border-bottom:2px solid var(--clr-border); background:var(--clr-surface-alt, #f8f9fa);">
                    <th style="text-align:left; padding:var(--sp-sm);">ID</th>
                    <th style="text-align:left; padding:var(--sp-sm);">Matricule</th>
                    <th style="text-align:center; padding:var(--sp-sm);">Photo</th>
                    <th style="text-align:left; padding:var(--sp-sm);">Nom & Prénom</th>
                    <th style="text-align:center; padding:var(--sp-sm);">Sexe</th>
                    <th style="text-align:center; padding:var(--sp-sm);">Absence</th>
                    <th style="text-align:center; padding:var(--sp-sm);">Type</th>
                    <th style="text-align:left; padding:var(--sp-sm);">Justification</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($etudiants as $index => $etudiant): 
                    $absenceExistante = $absencesMap[$etudiant['id']] ?? null;
                    $typeValue = $absenceExistante ? $absenceExistante['type'] : 'present';
                  ?>
                  <tr style="border-bottom:1px solid var(--clr-border-light);" data-etudiant-id="<?= $etudiant['id'] ?>">
                    <td style="padding:var(--sp-sm);"><?= $etudiant['id'] ?></td>
                    <td style="padding:var(--sp-sm);"><code><?= esc($etudiant['matricule']) ?></code></td>
                    <td style="text-align:center; padding:var(--sp-sm);">
                      <?php if (!empty($etudiant['photo_url'])): ?>
                        <img src="<?= esc($etudiant['photo_url']) ?>" alt="photo" style="width:35px; height:35px; border-radius:50%; object-fit:cover;">
                      <?php else: ?>
                        <div style="width:35px; height:35px; background:linear-gradient(135deg,var(--clr-navy),var(--clr-violet)); border-radius:50%; display:inline-flex; align-items:center; justify-content:center; color:white; font-size:12px; font-weight:bold;">
                          <?= strtoupper(substr($etudiant['prenom'], 0, 1) . substr($etudiant['nom'], 0, 1)) ?>
                        </div>
                      <?php endif; ?>
                    </td>
                    <td style="padding:var(--sp-sm);"><strong><?= esc($etudiant['nom']) ?></strong> <?= esc($etudiant['prenom']) ?></td>
                    <td style="text-align:center; padding:var(--sp-sm);"><?= $etudiant['sexe'] === 'F' ? '👩 F' : '👨 M' ?></td>
                    <td style="text-align:center; padding:var(--sp-sm);">
                      <label style="display:inline-flex; align-items:center; gap:6px; cursor:pointer;">
                        <input type="checkbox" name="est_absent[]" value="<?= $etudiant['id'] ?>" 
                               onchange="toggleAbsence(this, <?= $etudiant['id'] ?>)" 
                               <?= $typeValue !== 'present' ? 'checked' : '' ?>>
                        <span style="font-size:13px;">Absent</span>
                      </label>
                    </td>
                    <td style="text-align:center; padding:var(--sp-sm);">
                      <select name="type_absence[<?= $etudiant['id'] ?>]" class="type-absence" data-etudiant="<?= $etudiant['id'] ?>" 
                              style="padding:4px 8px; border-radius:var(--radius-md); border:1px solid var(--clr-border); background:white;"
                              <?= $typeValue === 'present' ? 'disabled' : '' ?>>
                        <option value="non_justifiee" <?= $typeValue === 'non_justifiee' ? 'selected' : '' ?>>Non justifiée</option>
                        <option value="justifiee" <?= $typeValue === 'justifiee' ? 'selected' : '' ?>>Justifiée</option>
                        <option value="retard" <?= $typeValue === 'retard' ? 'selected' : '' ?>>Retard</option>
                      </select>
                    </td>
                    <td style="padding:var(--sp-sm);">
                      <input type="text" name="motif[<?= $etudiant['id'] ?>]" class="motif-absence" 
                             placeholder="Motif..." style="width:100%; padding:6px 8px; border-radius:var(--radius-md); border:1px solid var(--clr-border);"
                             value="<?= esc($absenceExistante['motif'] ?? '') ?>"
                             <?= $typeValue === 'present' ? 'disabled' : '' ?>>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </form>
          <?php endif; ?>
        </div>
      </div>
    </section>

<!-- Modal de confirmation -->
<div id="modal-confirmation" class="modal" style="display:none;">
  <div class="modal-overlay" onclick="closeModal('modal-confirmation')"></div>
  <div class="modal-container" style="max-width:400px;">
    <div class="modal-header">
      <h3>Confirmation</h3>
      <button class="modal-close" onclick="closeModal('modal-confirmation')">&times;</button>
    </div>
    <div class="modal-body" id="confirmation-message"></div>
    <div class="modal-footer">
      <button class="btn btn-primary" onclick="closeModal('modal-confirmation')">Fermer</button>
    </div>
  </div>
</div>

<script>
function toggleAbsence(checkbox, etudiantId) {
    var typeSelect = document.querySelector(`select[name="type_absence[${etudiantId}]"]`);
    var motifInput = document.querySelector(`input[name="motif[${etudiantId}]"]`);
    
    if (checkbox.checked) {
        typeSelect.disabled = false;
        motifInput.disabled = false;
    } else {
        typeSelect.disabled = true;
        motifInput.disabled = true;
        typeSelect.value = 'non_justifiee';
        motifInput.value = '';
    }
}

function submitAbsences() {
    var form = document.getElementById('formAbsences');
    var seanceId = form.querySelector('input[name="seance_id"]').value;
    
    if (!seanceId) {
        showConfirmation('Aucune séance en cours. Veuillez sélectionner une classe avec un cours aujourd\'hui.', 'error');
        return;
    }
    
    var etudiantsAbsents = [];
    var types = [];
    var motifs = [];
    
    var rows = document.querySelectorAll('tbody tr');
    rows.forEach(function(row) {
        var checkbox = row.querySelector('input[name="est_absent[]"]');
        if (checkbox && checkbox.checked) {
            var etudiantId = checkbox.value;
            var typeSelect = row.querySelector(`select[name="type_absence[${etudiantId}]"]`);
            var motifInput = row.querySelector(`input[name="motif[${etudiantId}]"]`);
            
            etudiantsAbsents.push(etudiantId);
            types.push(typeSelect ? typeSelect.value : 'non_justifiee');
            motifs.push(motifInput ? motifInput.value : '');
        }
    });
    
    if (etudiantsAbsents.length === 0) {
        showConfirmation('Aucune absence à enregistrer. Tous les élèves sont présents.', 'info');
        return;
    }
    
    var postData = {
        seance_id: seanceId,
        etudiant_id: etudiantsAbsents,
        type: types,
        motif: motifs
    };
    
    fetch('/absences/saveAbsencesClass', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: new URLSearchParams(postData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showConfirmation(data.message + ' (' + data.count + ' absence(s) enregistrée(s))', 'success');
            setTimeout(() => window.location.reload(), 2000);
        } else {
            showConfirmation('Erreur: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showConfirmation('Erreur lors de l\'enregistrement des absences', 'error');
    });
}

function changerClasse() {
    var classeId = document.getElementById('classeSelect').value;
    if (classeId) {
        window.location.href = '/professeur/absences/' + classeId;
    }
}

function showConfirmation(message, type) {
    var modal = document.getElementById('modal-confirmation');
    var msgDiv = document.getElementById('confirmation-message');
    
    msgDiv.innerHTML = message;
    var color = type === 'error' ? '#dc3545' : (type === 'success' ? '#28a745' : '#17a2b8');
    msgDiv.style.color = color;
    
    modal.style.display = 'flex';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}
</script>

<style>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}
.modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}
.modal-container {
    position: relative;
    background: white;
    border-radius: 16px;
    width: 90%;
    max-width: 500px;
    z-index: 1001;
}
.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    border-bottom: 1px solid var(--clr-border);
}
.modal-body {
    padding: 20px;
}
.modal-footer {
    padding: 12px 20px;
    border-top: 1px solid var(--clr-border);
    text-align: right;
}
.modal-close {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
}
.btn-outline {
    background: transparent;
    border: 1px solid var(--clr-border);
    padding: 8px 16px;
    border-radius: 8px;
    cursor: pointer;
}
.badge-info {
    background: #e3f2fd;
    color: #1976d2;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
}
</style>

<?= view('inc/modals') ?>

<?= view('inc/footer') ?>