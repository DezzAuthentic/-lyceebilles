<?php
namespace App\Controller\Suivi;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Event\Event;

class GroupesController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('suivi');
    }

    public function index(){
        $etab = $this->getEtablissement();
        $user = $this->getUser();
        $this->loadModel("Tuteurs");
        $this->loadModel("Affectations");

        if($user->tuteurs){
            $tuteur = $this->Tuteurs->find('all',[
                'conditions' => ['Tuteurs.user_id'=>$user->id]
            ])->first();
        }else{
            $tuteur = $user->tuteur_secondaires[0]->tuteur;
        }

        /*$groupes = $this->Affectations->find("all",[
            'fields' => ['id'=>'Affectations.groupe_id','nom'=>'Groupes.nom'],
			'contain' => ['Groupes.Promotions','Inscriptions.Eleves'],
			'group' => ['Affectations.groupe_id'],
			'conditions' => ['Promotions.annee_id' => $etab->annee_id,'Eleves.tuteur_id' => $tuteur->id]
        ]);*/

        $groupes = $this->Groupes->find('all',[
            'contain' => ['Promotions','Affectations.Inscriptions.Eleves'=> [
                'conditions' => ['Eleves.tuteur_id' => $tuteur->id]
            ]],
			'conditions' => ['Promotions.annee_id' => $etab->annee_id]
        ]);
        //dd($groupes->toArray());
        $this->set(compact('groupes'));
    }

    public function fiche($id){
        $this->loadModel("Seances");

        $etab = $this->getEtablissement();

        $groupe = $this->Groupes->get($id,[
            "contain" => ['Affectations.Inscriptions.Eleves','Cours.Matieres',"Cours.Professeurs","Cours.Edt"]
        ]);

        $seances = $this->Seances->find('all',[
            'contain' => ['Cours.Matieres','Cours.Professeurs','Cours.Groupes','Presences'],
            'conditions' => ['Groupes.id' => $id]
        ]);

        $this->set(compact('groupe','seances'));
    }
}