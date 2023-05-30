<?php
namespace App\Controller\Suivi;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Cours Controller
 *
 * @property \App\Model\Table\CoursTable $Cours
 *
 * @method \App\Model\Entity\Cour[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CoursController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('suivi');
    }
    
    /**
     * Edit method
     *
     * @param string|null $id Cour id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function fiche($id = null)
    {
        $this->loadModel('Periodes');
        $etab = $this->getEtablissement();

        $cours = $this->Cours->get($id, [
            'contain' => ['Matieres','Professeurs','Groupes','Seances.Presences','Devoirs.Periodes']
        ]); 

        $this->loadModel('Seances');
        $seances = $this->Seances->find('all', [
            'contain' => ['Presences'],
            'conditions' => ['cours_id' => $id],
            'order' => ['id DESC']
        ])->toArray();
        
        $this->set(compact('cours', 'seances'));
    }

    public function cahierDeTexte($id = null)
    {
        $this->loadModel('Periodes');
        $etab = $this->getEtablissement();

        $cours = $this->Cours->get($id, [
            'contain' => ['Matieres','Professeurs','Groupes','Seances' => [
                'sort' => ['Seances.date' => 'Desc', 'Seances.duree' => 'Desc']
            ]]
        ]);
        
        $this->set(compact('cours'));
    }
    
    public function index(){
        $etab = $this->getEtablissement();
        $this->loadModel("Tuteurs");
        $user = $this->getUser();
        if($user->tuteurs){
            $tuteur = $this->Tuteurs->find('all',[
                'conditions' => ['Tuteurs.user_id'=>$user->id]
            ])->first();
        }else{
            $tuteur = $user->tuteur_secondaires[0]->tuteur;
        }

        $cours = $this->Cours->find('all',[
            'contain' => ['Matieres','Professeurs','Groupes.Promotions','Seances.Presences','Edt','Groupes.Affectations.Inscriptions.Eleves'=> [
                'conditions' => ['Eleves.tuteur_id' => $tuteur->id]
            ]],
            'conditions' => ['Promotions.annee_id' => $etab->annee_id]
        ]);
        $this->set(compact('cours'));
    }
}
