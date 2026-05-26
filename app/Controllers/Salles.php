<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Salles as SallesModel;

class Salles extends BaseController
{
    public function index(){ return $this->response->setJSON((new SallesModel())->findAll()); }
    public function show($id){ return $this->response->setJSON((new SallesModel())->find($id)); }
    public function create(){ $data=$this->request->getJSON(true); $id=(new SallesModel())->insert($data); return $this->response->setJSON(['id'=>$id]); }
    public function update($id){ $data=$this->request->getJSON(true); (new SallesModel())->update($id,$data); return $this->response->setJSON(['updated'=>true]); }
    public function delete($id){ (new SallesModel())->delete($id); return $this->response->setJSON(['deleted'=>true]); }
}
