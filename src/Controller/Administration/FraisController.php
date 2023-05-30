<?php
namespace App\Controller\Administration;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Frais Controller
 *
 * @property \App\Model\Table\FraisTable $Frais
 *
 * @method \App\Model\Entity\Frai[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FraisController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('admin');
    }

    public function ajouter(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            if($temp["serie_id"]==""){
                $temp["serie_id"] = null;
            }
            
            $frai = $this->Frais->newEntity();
            $frai = $this->Frais->patchEntity($frai, $temp);
            if (!$this->Frais->save($frai)) {
                $this->Flash->error(__("L'ajout n'a pu être effectué. Merci de réessayer."));
            }
            //dd($frai);
            return $this->redirect(['prefix'=>'administration','controller'=>'Etablissements','action' => 'parametrageFinancier']);
        }
    }

    public function editer(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $frai = $this->Frais->get($temp["id"]);
            $frai = $this->Frais->patchEntity($frai, $temp);
            if (!$this->Frais->save($frai)) {
                $this->Flash->error(__("L'édition n'a pu être enregistrée. Merci de réessayer."));
            }
            //dd($frai);
            return $this->redirect(['prefix'=>'administration','controller'=>'Etablissements','action' => 'parametrageFinancier']);
        }
    }

    public function supprimer(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $frai = $this->Frais->get($temp["id"]);
            if (!$this->Frais->delete($frai)) {
                $this->Flash->error(__("La suppression n'a pu être faite. Merci de réessayer."));
            }
            return $this->redirect(['prefix'=>'administration','controller'=>'Etablissements','action' => 'parametrageFinancier']);
        }
    }

    public function getFrais($id_promotion){
        $this->autoRender = false;

        $etab = $this->getEtablissement();
        $this->loadModel("Promotions");
        $promotion = $this->Promotions->get($id_promotion);
        if($promotion->serie_id)
        $frais = $this->Frais->find("all",[
            'contain' => ['Types','Niveaux','Series'],
            'conditions' => ['Niveaux.etablissement_id'=>$etab->id, "Frais.niveau_id" => $promotion->niveau_id,
            "Frais.serie_id" => $promotion->serie_id],
            'order' => ['Types.nom ASC']
            ]);
        else
        $frais = $this->Frais->find("all",[
            'contain' => ['Types','Niveaux','Series'],
            'conditions' => ['Niveaux.etablissement_id'=>$etab->id, "Frais.niveau_id" => $promotion->niveau_id],
            'order' => ['Types.nom ASC']
        ]);
        echo json_encode($frais->toArray());    
    }
   
}
