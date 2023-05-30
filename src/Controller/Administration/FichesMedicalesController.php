<?php
namespace App\Controller\Administration;

use App\Controller\AppController;
use Cake\Event\Event;
use cake\Routing\Router;

class FichesMedicalesController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('admin');
    }

    public function index(){
        
    }
    public function parametrage(){
        $this->loadModel('RenseignementTypes');
        $this->loadModel('Renseignements');
        $etab = $this->getEtablissement();  
        
        $types = $this->RenseignementTypes->find('list',[
            "conditions" => ['RenseignementTypes.status' => 1]
        ]);

        $renseignements = $this->Renseignements->find('all',[
            "contain" => ['RenseignementTypes'],
            "conditions" => ['RenseignementTypes.status' => 1,'RenseignementTypes.etablissement_id'=>$etab->id]
        ]);

        $this->set(compact('types','renseignements'));
    }

}