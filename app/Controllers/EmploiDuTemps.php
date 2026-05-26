<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EmploiDuTemps as EDTModel;

class EmploiDuTemps extends BaseController
{
    public function index(){ return $this->response->setJSON((new EDTModel())->findAll()); }
    public function show($id){ return $this->response->setJSON((new EDTModel())->find($id)); }
    public function create(){ $data=$this->request->getJSON(true); $id=(new EDTModel())->insert($data); return $this->response->setJSON(['id'=>$id]); }
    public function update($id){ $data=$this->request->getJSON(true); (new EDTModel())->update($id,$data); return $this->response->setJSON(['updated'=>true]); }
    public function delete($id){ (new EDTModel())->delete($id); return $this->response->setJSON(['deleted'=>true]); }
}
