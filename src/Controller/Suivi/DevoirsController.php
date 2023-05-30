<?php
namespace App\Controller\Suivi;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Devoirs Controller
 *
 * @property \App\Model\Table\DevoirsTable $Devoirs
 *
 * @method \App\Model\Entity\Devoir[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DevoirsController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('suivi');
    }

    public function fiche($id = null)
    {
        $devoir = $this->Devoirs->get($id, [
            'contain' => ['Cours.Matieres','Cours.Professeurs','Cours.Groupes.Affectations.Inscriptions.Eleves','Periodes','DevoirNotes']
        ]);
        
        $this->set(compact('devoir'));
    }

    public function index()
    {
        $etab = $this->getEtablissement();
        $this->loadModel('Tuteurs');
        $this->loadModel('Affectations');
        $user = $this->getUser();
        if($user->tuteurs){
            $tuteur = $this->Tuteurs->find('all',[
                'conditions' => ['Tuteurs.user_id'=>$user->id]
            ])->first();
        }else{
            $tuteur = $user->tuteur_secondaires[0]->tuteur;
        }

        $groupes_id = $this->Affectations->find("all",[
			'contain' => ['Groupes.Promotions','Inscriptions.Eleves'],
			'conditions' => ['Promotions.annee_id' => $etab->annee_id,'Eleves.tuteur_id' => $tuteur->id]
        ])->extract("groupe_id")->toArray();
        
        $devoirs = null;

        if(sizeof($groupes_id)>0){
            $devoirs = $this->Devoirs->find('all',[
                'contain' => ['Cours.Matieres','Cours.Groupes.Promotions','DevoirNotes.Eleves' => [
                    "conditions" => ["Eleves.tuteur_id" => $tuteur->id]
                ]],
                'conditions' => ['Promotions.annee_id' => $etab->annee_id, "Groupes.id IN" => $groupes_id],
                'order' => ['Devoirs.date' => 'Desc']
            ]);
        }

        $this->set(compact('devoirs'));
    }

}
