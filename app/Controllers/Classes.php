<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Classes as ClassesModel;

class Classes extends BaseController
{
    public function index(){ return $this->response->setJSON((new ClassesModel())->findAll()); }
    public function show($id){ return $this->response->setJSON((new ClassesModel())->find($id)); }
    public function create(){ $data=$this->request->getJSON(true); $id=(new ClassesModel())->insert($data); return $this->response->setJSON(['id'=>$id]); }
    public function update($id){ $data=$this->request->getJSON(true); (new ClassesModel())->update($id,$data); return $this->response->setJSON(['updated'=>true]); }
    public function delete($id){ (new ClassesModel())->delete($id); return $this->response->setJSON(['deleted'=>true]); }
}
