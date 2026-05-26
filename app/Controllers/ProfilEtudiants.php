<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProfilEtudiants as ProfilEtudiantsModel;

class ProfilEtudiants extends BaseController
{
    public function index(){ return $this->response->setJSON((new ProfilEtudiantsModel())->findAll()); }
    public function show($id){ return $this->response->setJSON((new ProfilEtudiantsModel())->find($id)); }
    public function create(){ $data=$this->request->getJSON(true); $id=(new ProfilEtudiantsModel())->insert($data); return $this->response->setJSON(['id'=>$id]); }
    public function update($id){ $data=$this->request->getJSON(true); (new ProfilEtudiantsModel())->update($id,$data); return $this->response->setJSON(['updated'=>true]); }
    public function delete($id){ (new ProfilEtudiantsModel())->delete($id); return $this->response->setJSON(['deleted'=>true]); }
}
