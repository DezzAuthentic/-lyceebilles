<?php
namespace App\Controller\Suivi;

use App\Controller\AppController;
use Cake\Event\Event;
use cake\Routing\Router;

class DashboardController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('suivi');
    }

    public function index(){
        $this->loadModel('DevoirNotes');
        $this->loadModel("Tuteurs");
        $this->loadModel("Affectations");

        $etab = $this->getEtablissement();
        $user = $this->getUser();

        if($user->tuteurs){
            $tuteur = $this->Tuteurs->find('all',[
                'conditions' => ['Tuteurs.user_id'=>$user->id]
            ])->first();
        }else{
            $tuteur = $user->tuteur_secondaires[0]->tuteur;
        }

        $affectations = $this->Affectations->find("all",[
            'fields' => ['eleve_id'=>'Eleves.id','nom'=>'Eleves.nom','prenom'=>'Eleves.prenom'],
			'contain' => ['Groupes.Promotions','Inscriptions.Eleves'],
			'conditions' => ['Promotions.annee_id' => $etab->annee_id,'Eleves.tuteur_id' => $tuteur->id]
        ])->toArray();

        foreach($affectations as $affectation){
            $mois = $this->DevoirNotes->find('all',[
                'fields' => ['num'=>'MONTH(Devoirs.date)','an'=>'YEAR(Devoirs.date)','moyenne'=>'AVG(DevoirNotes.note)', 'nombre'=>'COUNT(DevoirNotes.id)'],
                'contain' => ['Devoirs.Cours.Groupes.Promotions','Eleves'],
                'group' => ['MONTH(Devoirs.date)','YEAR(Devoirs.date)'],
                'order' => ['an' => 'ASC','num' => 'ASC'],
                'conditions' => ['Eleves.id'=>$affectation->eleve_id, 'DevoirNotes.note >='=> 0,'Promotions.annee_id' => $etab->annee_id]
            ]);
            $affectation->mois = $mois->toArray();
        }

        // dd($affectations);
        $this->set(compact('affectations'));
    }
}
