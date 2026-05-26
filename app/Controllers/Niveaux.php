<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Niveaux as NiveauxModel;

class Niveaux extends BaseController
{
    public function index(){ return $this->response->setJSON((new NiveauxModel())->findAll()); }
    public function show($id){ return $this->response->setJSON((new NiveauxModel())->find($id)); }
    public function create(){ $data=$this->request->getJSON(true); $id=(new NiveauxModel())->insert($data); return $this->response->setJSON(['id'=>$id]); }
    public function update($id){ $data=$this->request->getJSON(true); (new NiveauxModel())->update($id,$data); return $this->response->setJSON(['updated'=>true]); }
    public function delete($id){ (new NiveauxModel())->delete($id); return $this->response->setJSON(['deleted'=>true]); }
}
