<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SupportsCours as SupportsModel;

class SupportsCours extends BaseController
{
    public function index(){ return $this->response->setJSON((new SupportsModel())->findAll()); }
    public function show($id){ return $this->response->setJSON((new SupportsModel())->find($id)); }
    public function create(){ $data=$this->request->getJSON(true); $id=(new SupportsModel())->insert($data); return $this->response->setJSON(['id'=>$id]); }
    public function update($id){ $data=$this->request->getJSON(true); (new SupportsModel())->update($id,$data); return $this->response->setJSON(['updated'=>true]); }
    public function delete($id){ (new SupportsModel())->delete($id); return $this->response->setJSON(['deleted'=>true]); }
}
