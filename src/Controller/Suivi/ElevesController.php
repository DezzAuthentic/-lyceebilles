<?php
namespace App\Controller\Suivi;

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
        $this->viewBuilder()->setLayout('suivi');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    
    public function index(){
        $etab = $this->getEtablissement();
        $user = $this->getUser();
        $this->loadModel("Tuteurs");
        $this->loadModel("Inscriptions");

        if($user->tuteurs){
            $tuteur = $this->Tuteurs->find('all',[
                'conditions' => ['Tuteurs.user_id'=>$user->id]
            ])->first();
        }else{
            $tuteur = $user->tuteur_secondaires[0]->tuteur;
        }

        $eleves = $this->Eleves->find('all',[
            'contain' => ['Inscriptions'],
            'conditions' => ['Eleves.etablissement_id' => $etab->id, 'Eleves.tuteur_id' => $tuteur->id]
        ]);

        $inscriptions = $this->Inscriptions->find('all',[
            'contain' => ['Promotions','Eleves','Affectations.Groupes'],
            'conditions' => ['Promotions.annee_id' => $etab->annee_id, 'Eleves.tuteur_id' => $tuteur->id]
        ]);

        $this->set(compact('eleves','inscriptions'));
    }

    public function fiche($id){
        $eleve = $this->Eleves->get($id,[
            'contain' => ['Tuteurs.Users','Inscriptions.Affectations.Groupes','Inscriptions.Promotions.Annees']
        ]);
        $this->set(compact('eleve'));
    }

}
