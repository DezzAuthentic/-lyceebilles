<?php
namespace App\Controller\Administration;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Event\Event;

class PromotionsController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('admin');
    }

    public function ajouter(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $promotion = $this->Promotions->newEntity();
            $promotion = $this->Promotions->patchEntity($promotion, $temp);
            if (!$this->Promotions->save($promotion)) {
                $this->Flash->error(__("L'ajout n'a pu être effectué. Merci de réessayer."));
            }
            //dd($promotion);
            return $this->redirect(['prefix'=>'administration','controller'=>'Promotions','action' => 'parametrage']);
        }
    }

    public function editer(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            //dd($temp);
            $promotion = $this->Promotions->get($temp["id"]);
            $promotion = $this->Promotions->patchEntity($promotion, $temp);
            if (!$this->Promotions->save($promotion)) {
                $this->Flash->error(__("L'édition n'a pu être enregistrée. Merci de réessayer."));
            }
            //dd($promotion);
            return $this->redirect(['prefix'=>'administration','controller'=>'Promotions','action' => 'parametrage']);
        }
    }

    public function supprimer(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $promotion = $this->Promotions->get($temp["id"]);
            
            if (!$this->Promotions->delete($promotion)) {
                $this->Flash->error(__("La suppression n'a pu être faite. Merci de réessayer."));
            }
            return $this->redirect(['prefix'=>'administration','controller'=>'Promotions','action' => 'parametrage']);
        }
    }

    
    public function actionEnMasse(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $action = $temp['action'];
            $select = $temp['select'];
            if($action == "supprimer"){
                $ok=0;
                $nok=0;
                foreach ($select as $sel){
                    if($this->suppr($sel))$ok++;
                    else $nok++;
                }
                $this->Flash->success(__("Suppression de ".$ok." promotion(s). Echecs: ".$nok."."));
            }
            //$this->Flash->error(__(""));
        }
        return $this->redirect(['prefix'=>'administration','controller'=>'Promotions','action' => 'parametrage']);
    }


    //action en masse
    public function suppr($id){
        $promotion = $this->Promotions->get($id);
        if (!$this->Promotions->delete($promotion)) {
            return false;
        }
        return true;
    }

    public function gestion(){
        $etab = $this->getEtablissement();
        $promotions = $this->Promotions->find("all",[
            'contain' => ['Niveaux'],
            'conditions' => ['Promotions.annee_id'=>$etab->annee_id,'Niveaux.etablissement_id'=>$etab->id]
        ]);

        $niveaux = $this->Promotions->Niveaux->find("list",[
            "conditions" => ["Niveaux.etablissement_id"=>$etab->id]
        ]);
        $series = $this->Promotions->Series->find("list",[
            "conditions" => ["Series.etablissement_id"=>$etab->id]
        ]);

        $this->set(compact('promotions','niveaux','series'));  
    }

    public function parametrage(){
        $etab = $this->getEtablissement();
        $promotions = $this->Promotions->find("all",[
            'contain' => ['Niveaux'],
            'conditions' => ['Promotions.annee_id'=>$etab->annee_id,'Niveaux.etablissement_id'=>$etab->id],
            'order' => ['Niveaux.ordre' => 'Asc']
        ]);

        $niveaux = $this->Promotions->Niveaux->find("list",[
            "conditions" => ["Niveaux.etablissement_id"=>$etab->id]
        ]);
        $series = $this->Promotions->Series->find("list",[
            "conditions" => ["Series.etablissement_id"=>$etab->id]
        ]);
        $this->set(compact('promotions','niveaux','series'));  
    }

}