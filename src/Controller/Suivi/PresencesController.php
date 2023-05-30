<?php
namespace App\Controller\Suivi;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Presences Controller
 *
 * @property \App\Model\Table\PresencesTable $Presences
 *
 * @method \App\Model\Entity\Presence[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PresencesController extends AppController
{
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('suivi');
    }

    public function getTuteur(){
        $this->loadModel('Tuteurs');
        $user = $this->getUser();
        if($user->tuteurs){
            $tuteur = $this->Tuteurs->find('all',[
                'conditions' => ['Tuteurs.user_id'=>$user->id]
            ])->first();
        }else{
            $tuteur = $user->tuteur_secondaires[0]->tuteur;
        }
        return $tuteur;
    }

    public function index(){
        $etab = $this->getEtablissement();
        $tuteur = $this->getTuteur();
        $this->loadModel('Affectations');

        $affectations = $this->Affectations->find("all",[
            'fields' => ['eleve_id'=>'Eleves.id','nom'=>'Eleves.nom','prenom'=>'Eleves.prenom'],
			'contain' => ['Groupes.Promotions','Inscriptions.Eleves'],
			'conditions' => ['Promotions.annee_id' => $etab->annee_id,'Eleves.tuteur_id' => $tuteur->id]
        ])->toArray();

        foreach($affectations as $affectation){
            $retards = $this->Presences->find('all',[
                'contain' => ['Seances.Cours.Groupes.Promotions'],
                'conditions' => ['Promotions.annee_id'=>$etab->annee_id,'Presences.type'=>'retard','Presences.eleve_id'=>$affectation->eleve_id]
            ]);
            $affectation->retards = $retards->toArray();

            $absences = $this->Presences->find('all',[
                'contain' => ['Seances.Cours.Groupes.Promotions'],
                'conditions' => ['Promotions.annee_id'=>$etab->annee_id,'Presences.type'=>'absence','Presences.eleve_id'=>$affectation->eleve_id]
            ]);
            $affectation->absences = $absences->toArray();

            $renvois = $this->Presences->find('all',[
                'contain' => ['Seances.Cours.Groupes.Promotions'],
                'conditions' => ['Promotions.annee_id'=>$etab->annee_id,'Presences.type'=>'renvoi','Presences.eleve_id'=>$affectation->eleve_id]
            ]);
            $affectation->renvois = $renvois->toArray();
        }

        $presences = $this->Presences->find('all',[
            'contain' => ['Seances.Cours.Groupes.Promotions','Eleves','Seances.Cours.Matieres'],
            'conditions' => ['Promotions.annee_id'=>$etab->annee_id, 'Eleves.tuteur_id'=>$tuteur->id],
            'order' => ['Seances.date'=>'Desc']
        ]);

        $this->set(compact('affectations','presences'));
    }
}
