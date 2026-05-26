<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Seances as SeancesModel;

class Seances extends BaseController
{
    public function index(){ return $this->response->setJSON((new SeancesModel())->findAll()); }
    public function show($id){ return $this->response->setJSON((new SeancesModel())->find($id)); }
    public function create(){ $data=$this->request->getJSON(true); $id=(new SeancesModel())->insert($data); return $this->response->setJSON(['id'=>$id]); }
    public function update($id){ $data=$this->request->getJSON(true); (new SeancesModel())->update($id,$data); return $this->response->setJSON(['updated'=>true]); }
    public function delete($id){ (new SeancesModel())->delete($id); return $this->response->setJSON(['deleted'=>true]); }
}
