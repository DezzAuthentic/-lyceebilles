<?php
namespace App\Controller\Administration;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Event\Event;

class GroupesController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('admin');
    }

    public function parametrage(){
        $etab = $this->getEtablissement();
        $groupes = $this->Groupes->find("all",[
            'contain' => ["Promotions.Niveaux","Promotions.Series","Promotions.Inscriptions","Affectations"],
            'conditions' => ['Promotions.annee_id'=>$etab->annee_id,'Niveaux.etablissement_id'=>$etab->id],
            'order' => ["Niveaux.ordre ASC","Series.nom ASC", "Groupes.nom ASC"]
        ]);

        $groupes = $groupes->toArray();
        $effectifs = Array();
        $promo_id = null;
        foreach($groupes as $groupe){
            if($promo_id!=$groupe->promotion->id){
                if(!array_key_exists($groupe->promotion->niveau_id,$effectifs)) $effectifs[$groupe->promotion->niveau_id] = 0;
                $effectifs[$groupe->promotion->niveau_id] += sizeof($groupe->promotion->inscriptions);
                $promo_id = $groupe->promotion->id;
            }
        }

        $promotions = $this->Groupes->Promotions->find("list",[
            'contain' => ['Niveaux'],
            'conditions' => ['Promotions.annee_id'=>$etab->annee_id,'Niveaux.etablissement_id'=>$etab->id]
        ]);

        //dd($groupes->toArray());

        $this->set(compact('groupes','promotions','effectifs'));
    }

    public function ajouter(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $groupe = $this->Groupes->newEntity();
            $groupe = $this->Groupes->patchEntity($groupe, $temp);
            if (!$this->Groupes->save($groupe)) {
                $this->Flash->error(__("L'ajout n'a pu être effectué. Merci de réessayer."));
            }
            //dd($groupe);
            return $this->redirect(['prefix'=>'administration','controller'=>'Groupes','action' => 'parametrage']);
        }
    }

    public function editer(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $groupe = $this->Groupes->get($temp["id"]);
            $groupe = $this->Groupes->patchEntity($groupe, $temp);
            if (!$this->Groupes->save($groupe)) {
                $this->Flash->error(__("L'édition n'a pu être enregistrée. Merci de réessayer."));
            }
            //dd($groupe);
            return $this->redirect(['prefix'=>'administration','controller'=>'Groupes','action' => 'parametrage']);
        }
    }

    public function supprimer(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $groupe = $this->Groupes->get($temp["id"]);
            if (!$this->Groupes->delete($groupe)) {
                $this->Flash->error(__("La suppression n'a pu être faite. Merci de réessayer."));
            }
            return $this->redirect(['prefix'=>'administration','controller'=>'Groupes','action' => 'parametrage']);
        }
    }

}