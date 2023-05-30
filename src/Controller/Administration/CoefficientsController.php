<?php
namespace App\Controller\Administration;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Event\Event;

class CoefficientsController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('admin');
    }

    public function configuration(){
        $etab = $this->getEtablissement();
        $coefficients = $this->Coefficients->find("all",[
            'contain' => ["Niveaux",'Series',"Matieres"],
            'conditions' => ["Matieres.etablissement_id"=>$etab->id],
            'order' => ["Niveaux.ordre ASC", "Series.nom ASC"]
        ]);

        $niveaux = $this->Coefficients->Niveaux->find("list",[
            "conditions" => ["Niveaux.etablissement_id"=>$etab->id]
        ]);
        $series = $this->Coefficients->Series->find("list",[
            "conditions" => ["Series.etablissement_id"=>$etab->id]
        ]);
        $matieres = $this->Coefficients->Matieres->find("list",[
            "conditions" => ["Matieres.etablissement_id"=>$etab->id]
        ]);

        //dd($coefficients->toArray());

        $this->set(compact('coefficients','niveaux','series','matieres'));
    }

    public function ajouter(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            if($temp["serie_id"]==""){
                $temp["serie_id"] = null;
                $doublons = $this->Coefficients->find("all",[
                    "conditions" => ["Coefficients.niveau_id"=>$temp["niveau_id"], "Coefficients.serie_id is null","Coefficients.matiere_id"=>$temp["matiere_id"]]
                ]);
            }
            else {
                $doublons = $this->Coefficients->find("all",[
                    "conditions" => ["Coefficients.niveau_id"=>$temp["niveau_id"], "Coefficients.serie_id"=>$temp["serie_id"],"Coefficients.matiere_id"=>$temp["matiere_id"]]
                ]);
            }
            
            //dd($doublons->toArray());
            if($doublons->count()>0){
                $this->Flash->error(__("Ce coefficient existe déjà."));
                return $this->redirect(['prefix'=>'administration','controller'=>'Coefficients','action' => 'configuration']);
            }
            $coef = $this->Coefficients->newEntity();
            $coef = $this->Coefficients->patchEntity($coef, $temp);
            if (!$this->Coefficients->save($coef)) {
                $this->Flash->error(__("L'ajout n'a pu être effectué. Merci de réessayer."));
            }
            //dd($coef);
            return $this->redirect(['prefix'=>'administration','controller'=>'Coefficients','action' => 'configuration']);
        }
    }

    public function editer(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $coef = $this->Coefficients->get($temp["id"]);
            $coef = $this->Coefficients->patchEntity($coef, $temp);
            if (!$this->Coefficients->save($coef)) {
                $this->Flash->error(__("L'édition n'a pu être enregistrée. Merci de réessayer."));
            }
            //dd($coef);
            return $this->redirect(['prefix'=>'administration','controller'=>'Coefficients','action' => 'configuration']);
        }
    }

    public function supprimer(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $coef = $this->Coefficients->get($temp["id"]);
            if (!$this->Coefficients->delete($coef)) {
                $this->Flash->error(__("La suppression n'a pu être faite. Merci de réessayer."));
            }
            return $this->redirect(['prefix'=>'administration','controller'=>'Coefficients','action' => 'configuration']);
        }
    }

}