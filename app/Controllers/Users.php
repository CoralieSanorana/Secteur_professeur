<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Users as UsersModel;

class Users extends BaseController
{
    public function index(){ return $this->response->setJSON((new UsersModel())->findAll()); }
    public function show($id){ return $this->response->setJSON((new UsersModel())->find($id)); }
    public function create(){ $data=$this->request->getJSON(true); $id=(new UsersModel())->insert($data); return $this->response->setJSON(['id'=>$id]); }
    public function update($id){ $data=$this->request->getJSON(true); (new UsersModel())->update($id,$data); return $this->response->setJSON(['updated'=>true]); }
    public function delete($id){ (new UsersModel())->delete($id); return $this->response->setJSON(['deleted'=>true]); }
}
