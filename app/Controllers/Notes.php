<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Notes as NotesModel;

class Notes extends BaseController
{
    public function index(){ return $this->response->setJSON((new NotesModel())->findAll()); }
    public function show($id){ return $this->response->setJSON((new NotesModel())->find($id)); }
    public function create(){ $data=$this->request->getJSON(true); $id=(new NotesModel())->insert($data); return $this->response->setJSON(['id'=>$id]); }
    public function update($id){ $data=$this->request->getJSON(true); (new NotesModel())->update($id,$data); return $this->response->setJSON(['updated'=>true]); }
    public function delete($id){ (new NotesModel())->delete($id); return $this->response->setJSON(['deleted'=>true]); }

    public function affectation($affectationId)
    {
        $periodeId = $this->request->getGet('periode_id');
        $periodeId = $periodeId !== null && $periodeId !== '' ? (int) $periodeId : null;

        return $this->response->setJSON((new NotesModel())->getNotesByAffectation((int) $affectationId, $periodeId));
    }
}
