<?php
namespace App\Controller\Academie;

use App\Controller\AppController;
use App\Controller\Administration\EleveController;
use Cake\Event\Event;
use Cake\I18n\Time;

/**
 * Inscriptions Controller
 *
 * @property \App\Model\Table\InscriptionsTable $Inscriptions
 *
 * @method \App\Model\Entity\Inscription[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InscriptionsController extends AppController 
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('academie');
    }

    public function liste(){
        $etab = $this->getEtablissement();

        $inscriptions = $this->Inscriptions->find('all',[
            'contain' => ['Promotions','Eleves'],
            'conditions' => ['Promotions.annee_id'=>$etab->annee_id]
        ]);



        $this->set(compact('inscriptions'));
    }

    public function desactiver($id){
        $inscription = $this->Inscriptions->get($id);
        $inscription->etat = "suspendu";
        $this->Inscriptions->save($inscription);
        $this->redirect($this->referer()); 
    }
    public function activer($id){
        $inscription = $this->Inscriptions->get($id);
        $inscription->etat = "validé";
        $this->Inscriptions->save($inscription);
        $this->redirect($this->referer()); 
    }
}
