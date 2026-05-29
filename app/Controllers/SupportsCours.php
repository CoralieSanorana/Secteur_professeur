<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SupportsCours as SupportsModel;
use CodeIgniter\HTTP\RedirectResponse;

class SupportsCours extends BaseController
{
    private SupportsModel $model;

    public function __construct()
    {
        $this->model = new SupportsModel();
    }

    public function index()
    {
        return $this->response->setJSON($this->model->findAll());
    }

    public function show($id)
    {
        $row = $this->model->find($id);
        if (!$row) {
            return $this->response->setStatusCode(404)->setJSON(['message' => 'Support introuvable']);
        }

        return $this->response->setJSON($row);
    }

    public function create()
    {
        $data = $this->request->getJSON(true) ?? $this->request->getPost();
        $data['accepte_retard'] = !empty($data['accepte_retard']) ? 'true' : 'false';
        $data['is_archived'] = !empty($data['is_archived']) ? 'true' : 'false';
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
        if (array_key_exists('accepte_retard', $data)) {
            $data['accepte_retard'] = !empty($data['accepte_retard']) ? 'true' : 'false';
        }
        if (array_key_exists('is_archived', $data)) {
            $data['is_archived'] = !empty($data['is_archived']) ? 'true' : 'false';
        }
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
            return $this->response->setStatusCode(404)->setJSON(['message' => 'Support introuvable']);
        }

        $this->model->delete($id);
        return $this->response->setJSON(['deleted' => true]);
    }

    public function publier(): RedirectResponse|string
    {
        $file = $this->request->getFile('fichier');
        $fichierUrl = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'supports_cours';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);
            $fichierUrl = 'uploads/supports_cours/' . $newName;
        }

        $dateLimite = $this->request->getPost('date_limite');
        if (!empty($dateLimite)) {
            $timestamp = strtotime(str_replace('T', ' ', $dateLimite));
            $dateLimite = $timestamp !== false ? date('Y-m-d H:i:s', $timestamp) : $dateLimite;
        }

        $data = [
            'affectation_id' => (int) $this->request->getPost('affectation_id'),
            'type_fichier_id' => $this->request->getPost('type_fichier_id') !== '' ? (int) $this->request->getPost('type_fichier_id') : null,
            'titre' => trim((string) $this->request->getPost('titre')),
            'description' => trim((string) $this->request->getPost('description')),
            'fichier_url' => $fichierUrl,
            'type_contenu' => (string) $this->request->getPost('type_contenu'),
            'date_limite' => $dateLimite ?: null,
            'accepte_retard' => $this->request->getPost('accepte_retard') ? 'true' : 'false',
            'is_archived' => 'false',
            'cree_par' => null,
        ];

        $id = $this->model->insert($data);
        if ($id === false) {
            $errors = $this->model->errors();
            $message = 'Impossible de publier le cours.';

            if (!empty($errors)) {
                $message .= ' ' . implode(' ', array_values($errors));
            }

            return redirect()->to(base_url('professeur/devoirs'))->withInput()->with('error', $message);
        }

        return redirect()->to(base_url('professeur/devoirs'))->with('success', 'Cours publié avec succès.');
    }
}
