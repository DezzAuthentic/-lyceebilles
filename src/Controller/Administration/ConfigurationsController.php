<?php
namespace App\Controller\Administration;

use App\Controller\AppController;
use Cake\Event\Event;

class ConfigurationsController extends AppController
{
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('admin');
    }

    public function editer(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $config = $this->Configurations->get($temp["id"]);
            $config = $this->Configurations->patchEntity($config, $temp);
            if ($this->Configurations->save($config)) {
                return $this->redirect(['prefix'=>'administration','controller'=>'Etablissements','action' => 'parametrage']);
            }
            $this->Flash->error(__("L'édition n'a pu être enregistrée. Merci de réessayer."));
        }
    }
}