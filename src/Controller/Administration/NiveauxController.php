<?php
namespace App\Controller\Administration;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Event\Event;

class NiveauxController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('admin');
    }

    public function ajouter(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $niveau = $this->Niveaux->newEntity();
            $niveau = $this->Niveaux->patchEntity($niveau, $temp);
            if (!$this->Niveaux->save($niveau)) {
                $this->Flash->error(__("L'ajout n'a pu être effectué. Merci de réessayer."));
            }
            //dd($Niveau);
            return $this->redirect(['prefix'=>'administration','controller'=>'Etablissements','action' => 'parametrageGeneral']);
        }
    }

    public function editer(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $niveau = $this->Niveaux->get($temp["id"]);
            $niveau = $this->Niveaux->patchEntity($niveau, $temp);
            if (!$this->Niveaux->save($niveau)) {
                $this->Flash->error(__("L'édition n'a pu être enregistrée. Merci de réessayer."));
            }
            //dd($Niveau);
            return $this->redirect(['prefix'=>'administration','controller'=>'Etablissements','action' => 'parametrageGeneral']);
        }
    }

    public function supprimer(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $niveau = $this->Niveaux->get($temp["id"]);
            
            if (!$this->Niveaux->delete($niveau)) {
                $this->Flash->error(__("La suppression n'a pu être faite. Merci de réessayer."));
            }
            return $this->redirect(['prefix'=>'administration','controller'=>'Etablissements','action' => 'parametrageGeneral']);
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
                $this->Flash->success(__("Suppression de ".$ok." niveau(x). Echecs: ".$nok."."));
            }
            //$this->Flash->error(__(""));
        }
        return $this->redirect(['prefix'=>'administration','controller'=>'Etablissements','action' => 'parametrageGeneral']);        
    }


    //action en masse
    public function suppr($id){
        $niveau = $this->Niveaux->get($id);
        if (!$this->Niveaux->delete($niveau)) {
            return false;
        }
        return true;
    }
}