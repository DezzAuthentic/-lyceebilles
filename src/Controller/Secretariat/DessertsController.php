<?php
namespace App\Controller\Secretariat;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Event\Event;

/**
 * Desserts Controller
 *
 * @property \App\Model\Table\DessertsTable $Desserts
 *
 * @method \App\Model\Entity\Dessert[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DessertsController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('secretariat');
    }

    public function ajouter(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $dessert = $this->Desserts->newEntity();
            $dessert = $this->Desserts->patchEntity($dessert, $temp);
            if (!$this->Desserts->save($dessert)) {
                $this->Flash->error(__("L'ajout n'a pu être effectué. Merci de réessayer."));
            }
            return $this->redirect($this->referer());
        }
    }

    public function editer(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $dessert = $this->Desserts->get($temp["id"]);
            $dessert = $this->Desserts->patchEntity($dessert, $temp);
            if (!$this->Desserts->save($dessert)) {
                $this->Flash->error(__("L'édition n'a pu être enregistrée. Merci de réessayer."));
            }
            return $this->redirect($this->referer());
        }
    }

    public function supprimer(){
        try{
            if ($this->request->is('post')) {
                $temp = $this->request->getData();
                $dessert = $this->Desserts->get($temp["id"]);
                if (!$this->Desserts->delete($dessert)) {
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
        $dessert = $this->Desserts->get($id);
        try{
            if (!$this->Desserts->delete($desserts)) {
                return false;
            } 
        }catch(\Exception $e){
            return false;
        }
        return true;
    }
}
