<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TypesFichiers as TypesFichiersModel;

class TypesFichiers extends BaseController
{
    public function index(){ return $this->response->setJSON((new TypesFichiersModel())->findAll()); }
    public function show($id){ return $this->response->setJSON((new TypesFichiersModel())->find($id)); }
    public function create(){ $data=$this->request->getJSON(true); $id=(new TypesFichiersModel())->insert($data); return $this->response->setJSON(['id'=>$id]); }
    public function update($id){ $data=$this->request->getJSON(true); (new TypesFichiersModel())->update($id,$data); return $this->response->setJSON(['updated'=>true]); }
    public function delete($id){ (new TypesFichiersModel())->delete($id); return $this->response->setJSON(['deleted'=>true]); }
}
