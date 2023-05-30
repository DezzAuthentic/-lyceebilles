<?php
namespace App\Controller\Professorat;

use App\Controller\AppController;
use Cake\Event\Event;
use cake\Routing\Router;
/**
 * Eleves Controller
 *
 * @property \App\Model\Table\ElevesTable $Eleves
 *
 * @method \App\Model\Entity\Elef[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ElevesController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('prof');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    
    public function fiche($id){
        $eleve = $this->Eleves->get($id,[
            'contain' => ['Tuteurs.Users','Inscriptions.Affectations.Groupes','Inscriptions.Promotions.Annees']
        ]);
        $this->set(compact('eleve'));
    }
}
