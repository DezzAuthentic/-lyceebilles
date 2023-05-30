<?php
namespace App\Controller\Administration;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Mois Controller
 *
 * @property \App\Model\Table\MoisTable $Mois
 *
 * @method \App\Model\Entity\Mois[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MoisController extends AppController
{

    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('admin');
    }

    public function ajouter(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $moi = $this->Mois->newEntity();
            $moi = $this->Mois->patchEntity($moi, $temp);

            if (!$this->Mois->save($moi)) {
                $this->Flash->error(__("L'ajout n'a pu être effectué. Merci de réessayer."));
            }
            //dd($moi);
            return $this->redirect(['prefix'=>'administration','controller'=>'Etablissements','action' => 'parametrageFinancier']);
        }
    }

    public function editer(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $moi = $this->Mois->get($temp["id"]);
            $moi = $this->Mois->patchEntity($moi, $temp);
            if (!$this->Mois->save($moi)) {
                $this->Flash->error(__("L'édition n'a pu être enregistrée. Merci de réessayer."));
            }
            //dd($moi);
            return $this->redirect(['prefix'=>'administration','controller'=>'Etablissements','action' => 'parametrageFinancier']);
        }
    }

    public function supprimer(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $moi = $this->Mois->get($temp["id"]);
            
            if (!$this->Mois->delete($moi)) {
                $this->Flash->error(__("La suppression n'a pu être faite. Merci de réessayer."));
            }
            return $this->redirect(['prefix'=>'administration','controller'=>'Etablissements','action' => 'parametrageFinancier']);
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
                $this->Flash->success(__("Suppression de ".$ok." moi(x). Echecs: ".$nok."."));
            }
            //$this->Flash->error(__(""));
        }
        return $this->redirect(['prefix'=>'administration','controller'=>'Etablissements','action' => 'parametrageFinancier']);        
    }


    //action en masse
    public function suppr($id){
        $moi = $this->Mois->get($id);
        if (!$this->Mois->delete($moi)) {
            return false;
        }
        return true;
    }

}
