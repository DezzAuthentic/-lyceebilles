<?php
namespace App\Controller\Secretariat;

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
        $this->viewBuilder()->setLayout('secretariat');
    }

    public function getFrais($id_promotion){
        $this->autoRender = false;

        $etab = $this->getEtablissement();
        $this->loadModel("Promotions");
        $promotion = $this->Promotions->get($id_promotion);
        //if($promotion->serie_id)
        $frais = $this->Frais->find("all",[
            'contain' => ['Types','Niveaux','Series'],
            'conditions' => ['Niveaux.etablissement_id'=>$etab->id, "Frais.niveau_id" => $promotion->niveau_id,
            "Frais.serie_id IS" => $promotion->serie_id],
            'order' => ['Types.nom ASC']
        ]);
        /*else
        $frais = $this->Frais->find("all",[
            'contain' => ['Types','Niveaux','Series'],
            'conditions' => ['Niveaux.etablissement_id'=>$etab->id, "Frais.niveau_id" => $promotion->niveau_id],
            'order' => ['Types.nom ASC']
        ]);*/
        echo json_encode($frais->toArray());    
    }
   
}
