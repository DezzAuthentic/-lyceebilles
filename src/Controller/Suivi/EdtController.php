<?php
namespace App\Controller\Suivi;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Edt Controller
 *
 * @property \App\Model\Table\EdtTable $Edt
 *
 * @method \App\Model\Entity\Edt[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EdtController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('suivi');
    }

    public function classe($groupe_id){
        $this->loadModel("Groupes");
        $groupe = $this->Groupes->get($groupe_id,[
            "contain" => ['Cours.Matieres',"Cours.Professeurs"]
        ]);

        $edts = $this->Edt->find('all',[
            "contain" => ['Cours.Matieres','Cours.Professeurs'],
            'conditions' => ['Cours.groupe_id'=>$groupe_id]
        ]);
        
        $this->set(compact('groupe','edts'));
    }

}
