<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProfilProfesseurs as ProfilProfesseursModel;

class ProfilProfesseurs extends BaseController
{
    public function index(){ return $this->response->setJSON((new ProfilProfesseursModel())->findAll()); }
    public function show($id){ return $this->response->setJSON((new ProfilProfesseursModel())->find($id)); }
    public function create(){ $data=$this->request->getJSON(true); $id=(new ProfilProfesseursModel())->insert($data); return $this->response->setJSON(['id'=>$id]); }
    public function update($id){ $data=$this->request->getJSON(true); (new ProfilProfesseursModel())->update($id,$data); return $this->response->setJSON(['updated'=>true]); }
    public function delete($id){ (new ProfilProfesseursModel())->delete($id); return $this->response->setJSON(['deleted'=>true]); }
}
