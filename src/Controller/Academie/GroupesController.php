<?php
namespace App\Controller\academie;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Event\Event;

class GroupesController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('academie');
    }

    public function parametrage(){
        $etab = $this->getEtablissement();

        $groupes = $this->Groupes->find("all",[
            'contain' => ["Promotions.Niveaux","Promotions.Series","Promotions.Inscriptions","Affectations"],
            'conditions' => ['Promotions.annee_id'=>$etab->annee_id,'Niveaux.etablissement_id'=>$etab->id],
            'order' => ["Niveaux.ordre ASC","Series.nom ASC", "Groupes.nom ASC"]
        ]);

        $promotions = $this->Groupes->Promotions->find("list",[
            'contain' => ['Niveaux'],
            'conditions' => ['Promotions.annee_id'=>$etab->annee_id,'Niveaux.etablissement_id'=>$etab->id]
        ]);

        //dd($groupes->toArray());

        $this->set(compact('groupes','promotions'));
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
            return $this->redirect($this->referer());
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
            return $this->redirect($this->referer());
        }
    }

    public function supprimer(){
        try{
            if ($this->request->is('post')) {
                $temp = $this->request->getData();
                $groupe = $this->Groupes->get($temp["id"]);
                if (!$this->Groupes->delete($groupe)) {
                    $this->Flash->error(__("La suppression n'a pu être faite. Merci de réessayer."));
                }
                return $this->redirect($this->referer());
            }
        }catch(\Exception $e){
            $this->Flash->error(__("Impossible d'effectuer la suppression!"));
        }
        return $this->redirect($this->referer());
    }

    public function gestion($id){
        $this->loadModel('Matieres');
        $this->loadModel('Professeurs');
        $this->loadModel("Seances");

        $etab = $this->getEtablissement();

        $groupe = $this->Groupes->get($id,[
            "contain" => ['Affectations.Inscriptions.Eleves','Cours.Matieres',"Cours.Professeurs","Cours.Edt"]
        ]);

        $seances = $this->Seances->find('all',[
            'contain' => ['Cours.Matieres','Cours.Professeurs','Cours.Groupes','Presences'],
            'conditions' => ['Groupes.id' => $id]
        ]);

        $matieres_id = Array();
        foreach($groupe->cours as $cour){
            $matieres_id[] = $cour->matiere_id;
        }
        if(sizeof($matieres_id)>0){
            $matieres = $this->Matieres->find('all',[
                'conditions' => ['Matieres.etablissement_id' => $etab->id, 'Matieres.id NOT IN' => $matieres_id]
            ]);
        }else{
            $matieres = $this->Matieres->find('all',[
                'conditions' => ['Matieres.etablissement_id' => $etab->id]
            ]);
        }
        
        $professeurs = $this->Professeurs->find('all',[
            'contain' => ['Enseignees'],
            'conditions' => ['Professeurs.etablissement_id' => $etab->id]
        ]);
        $this->set(compact('groupe','matieres','professeurs','seances'));
    }

    public function index(){
        $etab = $this->getEtablissement();

        $groupes = $this->Groupes->find('all',[
            'contain' => ['Promotions.Niveaux','Affectations','Promotions.Inscriptions'],
            'conditions' => ['Promotions.annee_id'=> $etab->annee_id],
            'order' => ['Niveaux.ordre' => 'ASC']
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
        //dd($effectifs);
        $this->set(compact('groupes','effectifs'));
    }
}