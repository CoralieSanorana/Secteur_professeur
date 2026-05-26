<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Affectations as AffectationsModel;

class Affectations extends BaseController
{
    public function index(){ return $this->response->setJSON((new AffectationsModel())->findAll()); }
    public function show($id){ return $this->response->setJSON((new AffectationsModel())->find($id)); }
    public function create(){ $data=$this->request->getJSON(true); $id=(new AffectationsModel())->insert($data); return $this->response->setJSON(['id'=>$id]); }
    public function update($id){ $data=$this->request->getJSON(true); (new AffectationsModel())->update($id,$data); return $this->response->setJSON(['updated'=>true]); }
    public function delete($id){ (new AffectationsModel())->delete($id); return $this->response->setJSON(['deleted'=>true]); }
}
