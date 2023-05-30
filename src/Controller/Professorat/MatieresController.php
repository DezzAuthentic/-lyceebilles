<?php
namespace App\Controller\Professorat;

use App\Controller\AppController;
use Cake\Event\Event;
use cake\Routing\Router;

class MatieresController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('prof');
    }

    public function index(){
        $etab = $this->getEtablissement();

        $user_id = $this->logUser();
        $this->loadModel("Professeurs");
        $prof = $this->Professeurs->find('all',[
            'contain' => ['Matieres'],
            'conditions' => ['Professeurs.user_id'=>$user_id]
        ])->first();

        $matieres = $prof->matieres; 
        //dd($matieres);
        $this->set(compact('matieres'));
    }

    public function cours($matiere_id){
        $etab = $this->getEtablissement();

        $user_id = $this->logUser();
        $this->loadModel("Professeurs");
        $this->loadModel("Cours");

        $prof = $this->Professeurs->find('all',[
            'contain' => ['Matieres'],
            'conditions' => ['Professeurs.user_id'=>$user_id]
        ])->first();
        
        $matiere = $this->Matieres->get($matiere_id);

        if($matiere->professeur_id != $prof->id) {
            $this->Flash->error("Vous n'êtes pas habilité à consulter ces cours!");
            return $this->redirect($this->referer());
        }

        $cours = $this->Cours->find('all',[
            'contain' => ['Matieres','Professeurs','Groupes.Promotions','Seances.Presences','Edt'],
            'conditions' => ['Promotions.annee_id' => $etab->annee_id,'Matieres.id' => $matiere_id]
        ]);

        $this->set(compact('cours','matiere'));
    }

    public function seances($matiere_id){
        $this->loadModel('Groupes');
        $this->loadModel('Seances');
        $this->loadModel('Professeurs');

        $etab = $this->getEtablissement();

        $this->loadModel("Professeurs");
        $user_id = $this->logUser();
        $prof = $this->Professeurs->find('all',[
            'conditions' => ['Professeurs.user_id'=>$user_id]
        ])->first();

        $matiere = $this->Matieres->get($matiere_id);

        if($matiere->professeur_id != $prof->id) {
            $this->Flash->error("Vous n'êtes pas habilité à consulter ces cours!");
            return $this->redirect($this->referer());
        }

        $seances = $this->Seances->find('all',[
            'contain' => ['Cours.Matieres','Cours.Professeurs','Cours.Groupes.Promotions','Presences'],
            'conditions' => ['Promotions.annee_id' => $etab->annee_id, 'Matieres.id'=>$matiere_id]
        ]);

        $this->set(compact('seances','matiere'));
    }
}