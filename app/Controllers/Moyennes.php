<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Moyennes as MoyennesModel;

class Moyennes extends BaseController
{
    public function index(){ return $this->response->setJSON((new MoyennesModel())->findAll()); }
    public function show($id){ return $this->response->setJSON((new MoyennesModel())->find($id)); }
    public function create(){ $data=$this->request->getJSON(true); $id=(new MoyennesModel())->insert($data); return $this->response->setJSON(['id'=>$id]); }
    public function update($id){ $data=$this->request->getJSON(true); (new MoyennesModel())->update($id,$data); return $this->response->setJSON(['updated'=>true]); }
    public function delete($id){ (new MoyennesModel())->delete($id); return $this->response->setJSON(['deleted'=>true]); }
}
