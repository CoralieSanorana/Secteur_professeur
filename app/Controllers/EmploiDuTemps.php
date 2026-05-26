<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EmploiDuTemps as EDTModel;

class EmploiDuTemps extends BaseController
{
    private EDTModel $model;

    public function __construct()
    {
        $this->model = new EDTModel();
    }

    public function index()
    {
        return $this->response->setJSON($this->model->findAll());
    }

    public function show($id)
    {
        $row = $this->model->find($id);
        if (!$row) {
            return $this->response->setStatusCode(404)->setJSON(['message' => 'Emploi du temps introuvable']);
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
            return $this->response->setStatusCode(404)->setJSON(['message' => 'Emploi du temps introuvable']);
        }

        $this->model->delete($id);
        return $this->response->setJSON(['deleted' => true]);
    }

    public function getEmploiDuTempsByProfesseur($professeurId)
    {
        try {
            $emploiDuTemps = $this->model->getEmploiDuTempsByProfesseur((int) $professeurId);
        } catch (\Throwable $e) {
            log_message('error', 'Erreur emploi du temps professeur: {message}', ['message' => $e->getMessage()]);
            $emploiDuTemps = [];
        }

        return view('professeur/calendar', ['emploiDuTemps' => $emploiDuTemps]);
    }

}