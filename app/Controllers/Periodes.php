<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Periodes as PeriodesModel;

class Periodes extends BaseController
{
    public function index(){ return $this->response->setJSON((new PeriodesModel())->findAll()); }
    public function show($id){ return $this->response->setJSON((new PeriodesModel())->find($id)); }
    public function create(){ $data=$this->request->getJSON(true); $id=(new PeriodesModel())->insert($data); return $this->response->setJSON(['id'=>$id]); }
    public function update($id){ $data=$this->request->getJSON(true); (new PeriodesModel())->update($id,$data); return $this->response->setJSON(['updated'=>true]); }
    public function delete($id){ (new PeriodesModel())->delete($id); return $this->response->setJSON(['deleted'=>true]); }
}
