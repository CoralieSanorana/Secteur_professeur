<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Absences as AbsencesModel;

class Absences extends BaseController
{
    public function index(){ return $this->response->setJSON((new AbsencesModel())->findAll()); }
    public function show($id){ return $this->response->setJSON((new AbsencesModel())->find($id)); }
    public function create(){ $data=$this->request->getJSON(true); $id=(new AbsencesModel())->insert($data); return $this->response->setJSON(['id'=>$id]); }
    public function update($id){ $data=$this->request->getJSON(true); (new AbsencesModel())->update($id,$data); return $this->response->setJSON(['updated'=>true]); }
    public function delete($id){ (new AbsencesModel())->delete($id); return $this->response->setJSON(['deleted'=>true]); }
}
