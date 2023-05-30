<?php
namespace App\Controller\Administration;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Event\Event;

class RenseignementsController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('admin');
    }

    public function ajouter(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $renseignement = $this->Renseignements->newEntity();
            $renseignement = $this->Renseignements->patchEntity($renseignement, $temp);
            if (!$this->Renseignements->save($renseignement)) {
                $this->Flash->error(__("L'ajout n'a pu être effectué. Merci de réessayer."));
            }
            //dd($renseignement);
            return $this->redirect($this->referer());
        }
    }

    public function editer(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $renseignement = $this->Renseignements->get($temp["id"]);
            $renseignement = $this->Renseignements->patchEntity($renseignement, $temp);
            if (!$this->Renseignements ->save($renseignement)) {
                $this->Flash->error(__("L'édition n'a pu être enregistrée. Merci de réessayer."));
            }
            //dd($renseignements);
            return $this->redirect($this->referer());
        }
    }

    public function supprimer(){
        try{
            if ($this->request->is('post')) {
                $temp = $this->request->getData();
                $renseignement = $this->Renseignements->get($temp["id"]);
                
                if (!$this->Renseignements->delete($renseignement)) {
                    $this->Flash->error(__("La suppression n'a pu être faite. Merci de réessayer."));
                }
            }
        }catch(\Exception $e){
            $this->Flash->error(__("Impossible d'effectuer la suppression!"));
        }
        return $this->redirect($this->referer());
    }

    
    public function actionEnMasse(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            //dd($temp);
            $action = $temp['action'];
            $select = $temp['select'];
            if($action == "supprimer"){
                $ok=0;
                $nok=0;
                foreach ($select as $sel){
                    if($this->suppr($sel)) $ok++;
                    else $nok++;
                }
                $this->Flash->success(__("Suppression de ".$ok." champ(s). Echecs: ".$nok."."));
            }
            //$this->Flash->error(__(""));
        }
        return $this->redirect($this->referer());        
    }


    //action en masse
    public function suppr($id){
        try{
            $renseignement = $this->Renseignements->get($id);
            if (!$this->Renseignements->delete($renseignement)) {
                return false;
            }
        }catch(\Exception $e){
            $this->Flash->error(__("Impossible d'effectuer la suppression!"));
            return false; 
        }
        return true;
    }
}