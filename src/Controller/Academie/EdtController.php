<?php
namespace App\Controller\Academie;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Edt Controller
 *
 * @property \App\Model\Table\EdtTable $Edt
 *
 * @method \App\Model\Entity\Edt[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EdtController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('academie');
    }

    public function classe($groupe_id){
        $this->loadModel("Groupes");
        $groupe = $this->Groupes->get($groupe_id,[
            "contain" => ['Cours.Matieres',"Cours.Professeurs"]
        ]);

        $cours = $this->Edt->Cours->find('all',[
            'contain' => ['Matieres','Professeurs'],
            'conditions' => ['Cours.groupe_id' => $groupe_id]
        ]);

        $edts = $this->Edt->find('all',[
            "contain" => ['Cours.Matieres','Cours.Professeurs'],
            'conditions' => ['Cours.groupe_id'=>$groupe_id]
        ]);
        
        $this->set(compact('groupe','cours','edts'));
    }

    public function ajouter()
    {
        if ($this->request->is('post')) {
            $edt = $this->Edt->newEntity();
            $temp = $this->request->getData();
            $temp["debut"] = (float) $temp["debut"];
            $temp["duree"] = (float) $temp["duree"];
            $check = 1; $this->verifierDisponibilite($temp);
            if(!$check){
                $this->Flash->error(__("La plage horaire définie est déjà prise par un autre cours de la classe ou du professeur."));
            }else{
                $edt = $this->Edt->patchEntity($edt, $temp);
                if (!$this->Edt->save($edt)) {
                    $this->Flash->error(__("La séance n'a pu être enregistrée. Merci de réessayer."));
                    //dd($edt);
                }
            }
        }
        $this->redirect($this->referer());
    }

    public function supprimer($id){
        try{
            $edt = $this->Edt->get($id);
            if (!$this->Edt->delete($edt)) {
                $this->Flash->error(__("La suppression n'a pu être faite. Merci de réessayer."));
            }
            return $this->redirect($this->referer());
        }catch(\Exception $e){
            $this->Flash->error(__("Impossible d'effectuer la suppression!"));
        }
        return $this->redirect($this->referer());
    }

    /*
        Function de vérification de la disponibilité de la plage horaire reçue
        0 - la plage n'est pas disponible
        1 - la plage est libre
    */
    public function verifierDisponibilite($data){
        $this->loadModel('Cours');
        $etab = $this->getEtablissement();

        $cours_id = $data['cours_id'];
        $jour = $data['jour'];
        $debut = $data["debut"];
        $duree = $data["duree"];

        $cours = $this->Cours->get($cours_id);
        $edt_ex = $this->Edt->find("all",[
            "contain" => ['Cours.Groupes.Promotions'],
            'conditions' => [
                'Edt.jour' => $jour,
                'or' => [
                    'Cours.groupe_id' => $cours->groupe_id,
                    'and' => [
                        'Promotions.annee_id' => $etab->annee_id,
                        'Cours.professeur_id'  => $cours->professeur_id
                    ]
                    
                ]
            ]
        ]);

        foreach($edt_ex as $edt){
            if($edt->debut >= $debut and $edt->debut < $debut+$duree) return 0;
            else{
                for($i=0.5;$i<3;$i=$i+0.5){
                    if($edt->debut == $debut-$i and $edt->duree > $i) return 0;
                }
            }
        }
        return 1;
    }
} 
