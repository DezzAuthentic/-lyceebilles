<?php
namespace App\Controller\Administration;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Event\Event;

class SeriesController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('admin');
    }

    public function ajouter(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $serie = $this->Series->newEntity();
            $serie = $this->Series->patchEntity($serie, $temp);
            if (!$this->Series->save($serie)) {
                $this->Flash->error(__("L'ajout n'a pu être effectué. Merci de réessayer."));
            }
            //dd($serie);
            return $this->redirect(['prefix'=>'administration','controller'=>'Etablissements','action' => 'parametrageGeneral']);
        }
    }

    public function editer(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $serie = $this->Series->get($temp["id"]);
            $serie = $this->Series->patchEntity($serie, $temp);
            if (!$this->Series->save($serie)) {
                $this->Flash->error(__("L'édition n'a pu être enregistrée. Merci de réessayer."));
            }
            //dd($serie);
            return $this->redirect(['prefix'=>'administration','controller'=>'Etablissements','action' => 'parametrageGeneral']);
        }
    }

    public function supprimer(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $serie = $this->Series->get($temp["id"]);
            
            if (!$this->Series->delete($serie)) {
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
                $this->Flash->success(__("Suppression de ".$ok." série(s). Echecs: ".$nok."."));
            }
            //$this->Flash->error(__(""));
        }
        return $this->redirect(['prefix'=>'administration','controller'=>'Etablissements','action' => 'parametrageGeneral']);        
    }


    //action en masse
    public function suppr($id){
        $serie = $this->Series->get($id);
        if (!$this->Series->delete($serie)) {
            return false;
        }
        return true;
    }
}