<?php
  $pageTitle = 'Notes des Élèves';
  $activePage = 'prof-notes';
  $activeRole = 'professeur';
  $userName = 'Prof. Rabe';
  $userRole = 'Professeur';
  $userInitials = 'RB';
?>
    
<?= view('inc/header',['pageTitle' => $pageTitle, 'activePage' => $activePage]) ?>

    <section class="page-section active" id="prof-notes">
      <div class="page-header">
        <div><h2>Notes des Élèves</h2><p>Saisie et gestion des notes</p></div>
        <div class="page-header-actions">
          <select class="form-control" style="width:auto;padding:8px 12px;">
            <option>Terminale C</option><option>1ère C</option>
          </select>
          <select class="form-control" style="width:auto;padding:8px 12px;">
            <option>Trimestre 2</option><option>Trimestre 1</option>
          </select>
          <button class="btn btn-primary" onclick="showToast('📊 Notes enregistrées !')"><i class="fas fa-save"></i> Enregistrer</button>
        </div>
      </div>
      <div class="card">
        <div class="table-wrapper">
          <table>
            <thead><tr><th>Élève</th><th>Devoir 1</th><th>Devoir 2</th><th>Interrogation</th><th>Examen</th><th>Moyenne</th><th>Rang</th></tr></thead>
            <tbody>
              <tr>
                <td>Rakoto Jean</td>
                <td><input type="number" class="form-control" value="16" min="0" max="20" style="width:70px;padding:6px;text-align:center;"/></td>
                <td><input type="number" class="form-control" value="14" min="0" max="20" style="width:70px;padding:6px;text-align:center;"/></td>
                <td><input type="number" class="form-control" value="17" min="0" max="20" style="width:70px;padding:6px;text-align:center;"/></td>
                <td><input type="number" class="form-control" value="15" min="0" max="20" style="width:70px;padding:6px;text-align:center;"/></td>
                <td class="grade-excellent">15.5</td>
                <td><strong style="color:var(--clr-amber);">1er</strong></td>
              </tr>
              <tr>
                <td>Andria Miora</td>
                <td><input type="number" class="form-control" value="13" min="0" max="20" style="width:70px;padding:6px;text-align:center;"/></td>
                <td><input type="number" class="form-control" value="12" min="0" max="20" style="width:70px;padding:6px;text-align:center;"/></td>
                <td><input type="number" class="form-control" value="14" min="0" max="20" style="width:70px;padding:6px;text-align:center;"/></td>
                <td><input type="number" class="form-control" value="13" min="0" max="20" style="width:70px;padding:6px;text-align:center;"/></td>
                <td class="grade-good">13.0</td>
                <td><strong style="color:var(--clr-text-secondary);">2ème</strong></td>
              </tr>
              <tr>
                <td>Hery Njaka</td>
                <td><input type="number" class="form-control" value="9" min="0" max="20" style="width:70px;padding:6px;text-align:center;"/></td>
                <td><input type="number" class="form-control" value="8" min="0" max="20" style="width:70px;padding:6px;text-align:center;"/></td>
                <td><input type="number" class="form-control" value="10" min="0" max="20" style="width:70px;padding:6px;text-align:center;"/></td>
                <td><input type="number" class="form-control" value="7" min="0" max="20" style="width:70px;padding:6px;text-align:center;"/></td>
                <td class="grade-fail">8.5</td>
                <td><strong style="color:var(--clr-text-secondary);">3ème</strong></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

<?= view('inc/modals') ?>

<?= view('inc/footer') ?>