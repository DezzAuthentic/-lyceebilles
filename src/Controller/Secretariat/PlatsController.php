<?php
namespace App\Controller\Secretariat;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Event\Event;

/**
 * Plats Controller
 *
 * @property \App\Model\Table\PlatsTable $Plats
 *
 * @method \App\Model\Entity\Plat[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PlatsController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('secretariat');
    }

    public function ajouter(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $plat = $this->Plats->newEntity();
            $plat = $this->Plats->patchEntity($plat, $temp);
            if (!$this->Plats->save($plat)) {
                $this->Flash->error(__("L'ajout n'a pu être effectué. Merci de réessayer."));
            }
            return $this->redirect($this->referer());
        }
    }

    public function editer(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $plat = $this->Plats->get($temp["id"]);
            $plat = $this->Plats->patchEntity($plat, $temp);
            if (!$this->Plats->save($plat)) {
                $this->Flash->error(__("L'édition n'a pu être enregistrée. Merci de réessayer."));
            }
            return $this->redirect($this->referer());
        }
    }

    public function supprimer(){
        try{
            if ($this->request->is('post')) {
                $temp = $this->request->getData();
                $plat = $this->Plats->get($temp["id"]);
                if (!$this->Plats->delete($plat)) {
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
            $action = $temp['action'];
            $select = $temp['select'];
            if($action == "supprimer"){
                $ok=0;
                $nok=0;
                foreach ($select as $sel){
                    if($this->suppr($sel))$ok++;
                    else $nok++;
                }
                $this->Flash->success(__("Suppression de ".$ok." type(s). Echecs: ".$nok."."));
            }
            //$this->Flash->error(__(""));
        }
        return $this->redirect(['prefix'=>'finance','controller'=>'Etablissements','action' => 'parametrageFinancier']);        
    }


    //action en masse
    public function suppr($id){
        $plat = $this->Plats->get($id);
        try{
            if (!$this->Plats->delete($plats)) {
                return false;
            } 
        }catch(\Exception $e){
            return false;
        }
        return true;
    }
}
