<?php
namespace App\Controller\Administration;

use App\Controller\AppController;
use Cake\Event\Event;

class AnneesController extends AppController
{
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('admin');
    }

    public function configuration(){
        $etab = $this->getEtablissement();
        $annees = $this->Annees->find('all',[
            'conditions' => ['Annees.etablissement_id'=>$etab->id],
            'order'=>['Annees.id DESC']
        ]);
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            if(isset($temp['id'])) $annee = $this->Annees->get($temp["id"]);
            else $annee = $this->Annees->newEntity();
            $annee = $this->Annees->patchEntity($annee, $temp);
            //dd($annee);
            $annee->etablissement_id = $this->getEtablissement()->id;
            if ($this->Annees->save($annee)) {
                return $this->redirect(['prefix'=>'administration','controller'=>'Annees','action' => 'configuration']);
            }
            $this->Flash->error(__("L'édition n'a pu être enregistrée. Merci de réessayer."));
        }
        $list_mois = $this->Etablissements->Mois->find("list",[
            'conditions' => ['Mois.etablissement_id'=>$etab->id]
        ]);
        //dd($list_mois->toArray());
        $this->set(compact('annees','list_mois'));
    }

    public function supprimer($id){
        $this->request->allowMethod(['post', 'delete']);
        $annee = $this->Annees->get($id);
        if ($this->Annees->delete($annee)) {
        } else {
            $this->Flash->error(__("L'année n'a pu être supprimée. Merci de réessayer."));
        }

        return $this->redirect(['action' => 'configuration']);
    }
}