<?php
namespace App\Controller\Academie;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;

/**
 * Affectations Controller
 *
 * @property \App\Model\Table\AffectationsTable $Affectations
 *
 * @method \App\Model\Entity\Affectation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AffectationsController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('academie');
    }

    public function ajoutMasse(){
        if ($this->request->is('post')) {
            $ok=0;
            $temp = $this->request->getData();
            //dd($temp);
            if(isset($temp['inscrits'])){
                foreach($temp['inscrits'] as $inscrit){
                    $affectation = $this->Affectations->newEntity();
                    $affectation->date = Time::now();
                    $affectation->groupe_id = $temp['groupe_id'];
                    $affectation->inscription_id = $inscrit;
                    if($this->Affectations->save($affectation)) $ok++;
                }
                if($ok>0) $this->Flash->success("Affectation de ".$ok." élève(s).");
                else $this->Flash->error("Un problème est survenu. Merci de réessayer.");
            }
            else $this->Flash->error("Merci de sélectionner des élèves avant de valider.");
            return $this->redirect($this->referer());
        }
    }

    public function getDetails($affectation_id){
        $this->autoRender = false;
        $this->loadModel('Promotions');
        $etab = $this->getEtablissement();

        $affectation = $this->Affectations->get($affectation_id,[
            'contain' => ['Inscriptions.Promotions','Groupes']
        ]);

        $promotions = $this->Promotions->find("all",[
            'contain' => ['Groupes'],
            'conditions' => ['Promotions.annee_id'=>$etab->annee_id,'Promotions.niveau_id'=>$affectation->inscription->promotion->niveau_id]
        ]);

        $affectation->promotions = $promotions->toArray();

        echo json_encode($affectation);
    }
}
