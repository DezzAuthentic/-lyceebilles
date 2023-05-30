<?php
namespace App\Controller\Academie;

use App\Controller\AppController;

/**
 * DevoirNotes Controller
 *
 * @property \App\Model\Table\DevoirNotesTable $DevoirNotes
 *
 * @method \App\Model\Entity\DevoirNote[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DevoirNotesController extends AppController
{

    public function supprimer($note_id){
        if($note_id){
            $note = $this->DevoirNotes->get($note_id);
            if($note) $this->DevoirNotes->delete($note);
        } 
        return $this->redirect($this->referer());
    }
}
