<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Matieres as MatieresModel;

class Matieres extends BaseController
{
    public function index()
    {
        $model = new MatieresModel();
        return $this->response->setJSON($model->findAll());
    }

    public function show($id)
    {
        $model = new MatieresModel();
        return $this->response->setJSON($model->find($id));
    }

    public function create()
    {
        $data = $this->request->getJSON(true);
        $model = new MatieresModel();
        $id = $model->insert($data);
        return $this->response->setJSON(['id' => $id]);
    }

    public function update($id)
    {
        $data = $this->request->getJSON(true);
        $model = new MatieresModel();
        $model->update($id, $data);
        return $this->response->setJSON(['updated' => true]);
    }

    public function delete($id)
    {
        $model = new MatieresModel();
        $model->delete($id);
        return $this->response->setJSON(['deleted' => true]);
    }
}
