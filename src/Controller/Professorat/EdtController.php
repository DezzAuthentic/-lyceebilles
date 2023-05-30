<?php
namespace App\Controller\Professorat;

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
        $this->viewBuilder()->setLayout('prof');
    }

    public function index(){
        $etab = $this->getEtablissement();

        $user_id = $this->logUser();
        $this->loadModel("Professeurs");
        $prof = $this->Professeurs->find('all',[
            'conditions' => ['Professeurs.user_id'=>$user_id]
        ])->first();

        $edts = $this->Edt->find('all',[
            "contain" => ['Cours.Matieres','Cours.Professeurs','Cours.Groupes.Promotions'],
            'conditions' => ['Cours.professeur_id'=>$prof->id, 'Promotions.annee_id' => $etab->annee_id,]
        ]);

        $cours = $this->Edt->Cours->find('all',[
            'contain' => ['Matieres','Professeurs','Groupes.Promotions'],
            'conditions' => ['Promotions.annee_id' => $etab->annee_id, 'Professeurs.id'=>$prof->id]
        ]);

        $this->set(compact('edts','cours'));
    }
}
