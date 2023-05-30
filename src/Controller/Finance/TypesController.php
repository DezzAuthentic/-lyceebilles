<?php
namespace App\Controller\Finance;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Types Controller
 *
 * @property \App\Model\Table\TypesTable $Types
 *
 * @method \App\Model\Entity\Type[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TypesController extends AppController
{

    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('finance');
    }

    public function ajouter(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $type = $this->Types->newEntity();
            $type = $this->Types->patchEntity($type, $temp);
            /*if($type->nom=='Inscription' or $type->nom=='Scolarité'){
                $this->Flash->error(__("Ce nom ne peut être utilisé."));
                return $this->redirect($this->referer());
            }*/
            if (!$this->Types->save($type)) {
                $this->Flash->error(__("L'ajout n'a pu être effectué. Merci de réessayer."));
            }
            //dd($type);
            return $this->redirect(['prefix'=>'finance','controller'=>'Etablissements','action' => 'parametrageFinancier']);
        }
    }

    public function editer(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $type = $this->Types->get($temp["id"]);
            /*if($type->nom=='Inscription' or $type->nom=='Scolarité'){
                $this->Flash->error(__("Ce type ne peut être édité."));
                return $this->redirect($this->referer());
            }*/
            $type = $this->Types->patchEntity($type, $temp);
            if (!$this->Types->save($type)) {
                $this->Flash->error(__("L'édition n'a pu être enregistrée. Merci de réessayer."));
            }
            //dd($type);
            return $this->redirect(['prefix'=>'finance','controller'=>'Etablissements','action' => 'parametrageFinancier']);
        }
    }

    public function supprimer(){
        try{
            if ($this->request->is('post')) {
                $temp = $this->request->getData();
                $type = $this->Types->get($temp["id"]);
                /*if($type->nom=='Inscription' or $type->nom=='Scolarité'){
                    $this->Flash->error(__("Ce type ne peut être supprimé."));
                    return $this->redirect($this->referer());
                }*/
                if (!$this->Types->delete($type)) {
                    $this->Flash->error(__("La suppression n'a pu être faite. Merci de réessayer."));
                }
            }
        }catch(\Exception $e){
            $this->Flash->error(__("Impossible d'effectuer la suppression!"));
        }
        return $this->redirect(['prefix'=>'finance','controller'=>'Etablissements','action' => 'parametrageFinancier']);
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
        $type = $this->Types->get($id);
        try{
            if (!$this->Types->delete($type)) {
                return false;
            } 
        }catch(\Exception $e){
            return false;
        }
        return true;
    }
}
