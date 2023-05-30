<?php
namespace App\Controller\Academie;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;


class RemediationSeancesController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('academie');
    }

    public function ajouter(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $remediation_id = $temp['remediation_id'];
            $seance = $this->RemediationSeances->newEntity();
            $seance = $this->RemediationSeances->patchEntity($seance, $temp);
            $seance->status = 1;
            $seance->created = Time::now();
            if(!$this->RemediationSeances->save($seance)){
                $this->Flash->error(__("La séance n'a pu ajoutée. Merci de réessayer."));
            }
        }
        return $this->redirect($this->referer());
    }
    public function modifier(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            //dd($temp);
            $seance = $this->RemediationSeances->get($temp['seance_id']);
            $seance = $this->RemediationSeances->patchEntity($seance, $temp);
            $seance->status = 1;
            if(!$this->RemediationSeances->save($seance)){
                $this->Flash->error(__("La séance n'a pu modifiée. Merci de réessayer."));
            }
        }
        return $this->redirect($this->referer());
    }

    public function supprimer($id = null)
    {
        try{
            $this->request->allowMethod(['post', 'delete']);
            $seance = $this->RemediationSeances->get($id);
            if (!$this->RemediationSeances->delete($seance)) {
                $this->Flash->error(__("La séance n'a pu être supprimée. Merci de réessayer."));
            }
        }catch(\Exception $e){
            $this->Flash->error(__("Impossible d'effectuer la suppression!"));
        }
        return $this->redirect($this->referer());
    }
}
