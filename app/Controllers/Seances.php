<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Seances as SeancesModel;

class Seances extends BaseController
{
    private SeancesModel $model;

    public function __construct()
    {
        $this->model = new SeancesModel();
    }

    public function index()
    {
        $professeurId = $this->request->getGet('professeur_id');
        $dateDebut = $this->request->getGet('date_debut');
        $dateFin = $this->request->getGet('date_fin');

        if (!empty($professeurId)) {
            return $this->response->setJSON(
                $this->model->getSeancesByProfesseur((int) $professeurId, $dateDebut, $dateFin)
            );
        }

        return $this->response->setJSON($this->model->findAll());
    }

    public function show($id)
    {
        $row = $this->model->find($id);
        if (!$row) {
            return $this->response->setStatusCode(404)->setJSON(['message' => 'Séance introuvable']);
        }

        return $this->response->setJSON($row);
    }

    public function create()
    {
        $data = $this->request->getJSON(true) ?? $this->request->getPost();
        $id = $this->model->insert($data);

        if ($id === false) {
            return $this->response->setStatusCode(422)->setJSON([
                'message' => 'Données invalides',
                'errors' => $this->model->errors(),
            ]);
        }

        return $this->response->setStatusCode(201)->setJSON(['id' => $id]);
    }

    public function update($id)
    {
        $data = $this->request->getJSON(true) ?? $this->request->getRawInput();
        $ok = $this->model->update($id, $data);

        if ($ok === false) {
            return $this->response->setStatusCode(422)->setJSON([
                'message' => 'Mise à jour refusée',
                'errors' => $this->model->errors(),
            ]);
        }

        return $this->response->setJSON(['updated' => true]);
    }

    public function delete($id)
    {
        if (!$this->model->find($id)) {
            return $this->response->setStatusCode(404)->setJSON(['message' => 'Séance introuvable']);
        }

        $this->model->delete($id);
        return $this->response->setJSON(['deleted' => true]);
    }
}
