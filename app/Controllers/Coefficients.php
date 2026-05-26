<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Coefficients as CoefficientsModel;

class Coefficients extends BaseController
{
    public function index(){ return $this->response->setJSON((new CoefficientsModel())->findAll()); }
    public function show($id){ return $this->response->setJSON((new CoefficientsModel())->find($id)); }
    public function create(){ $data=$this->request->getJSON(true); $id=(new CoefficientsModel())->insert($data); return $this->response->setJSON(['id'=>$id]); }
    public function update($id){ $data=$this->request->getJSON(true); (new CoefficientsModel())->update($id,$data); return $this->response->setJSON(['updated'=>true]); }
    public function delete($id){ (new CoefficientsModel())->delete($id); return $this->response->setJSON(['deleted'=>true]); }
}
