<?php
namespace App\Controller\Professorat;

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
        $this->viewBuilder()->setLayout('prof');
    }

    public function index(){
        $this->loadModel('Groupes');
        $etab = $this->getEtablissement();

        $this->loadModel("Professeurs");
        $user_id = $this->logUser();
        $prof = $this->Professeurs->find('all',[
            'conditions' => ['Professeurs.user_id'=>$user_id]
        ])->first();

        $cours_groupes_id = $this->Devoirs->Cours->find('all',[
            'contain' => ['Matieres','Professeurs','Groupes.Promotions','Seances.Presences','Edt'],
            'conditions' => ['Promotions.annee_id' => $etab->annee_id, 'Professeurs.id'=>$prof->id]
        ])->extract('groupe_id')->toArray();

        $groupes = $this->Groupes->find('all',[
            'contain' => ['Promotions.Niveaux','Affectations','Promotions.Inscriptions'],
            'conditions' => ['Promotions.annee_id'=> $etab->annee_id, 'Groupes.id IN'=> $cours_groupes_id],
            'order' => ['Niveaux.ordre' => 'ASC']
        ]);

        $this->set(compact('groupes'));
    }

    public function ajouter(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $temp['date'] .= ' '.$temp['heure'];
            
            $devoir = $this->Devoirs->newEntity();
            $devoir = $this->Devoirs->patchEntity($devoir, $temp);
            if(!$this->Devoirs->save($devoir)){
                $this->Flash->error(__("Le devoir n'a pu être ajouté. Merci de réessayer."));
                dd($devoir);
                return $this->redirect($this->referer());
            }
            return $this->redirect(['action' => 'fiche', $devoir->id]);
        }
    }

    public function classe($id=null){
        $etab = $this->getEtablissement();

        $user_id = $this->logUser();
        $this->loadModel("Professeurs");
        $prof = $this->Professeurs->find('all',[
            'conditions' => ['Professeurs.user_id'=>$user_id]
        ])->first();

        $cours = $this->Devoirs->Cours->find('all',[
            'contain' => ['Matieres','Professeurs','Groupes.Promotions'],
            'conditions' => ['Promotions.annee_id' => $etab->annee_id, 'Professeurs.id'=>$prof->id]
        ]);

        $periodes = $this->Devoirs->Periodes->find('list',[
            'conditions' => ['Periodes.annee_id' => $etab->annee_id, 'Periodes.statut !='=>'clôturé']
        ]);

        $groupe = null;

        if($id==null){
            $devoirs = $this->Devoirs->find('all',[
                'contain' => ['Cours.Matieres','Cours.Professeurs','Cours.Groupes.Promotions'],
                'conditions' => ['Promotions.annee_id' => $etab->annee_id, 'Professeurs.id'=>$prof->id]
            ]);
        }else{
            $devoirs = $this->Devoirs->find('all',[
                'contain' => ['Cours.Matieres','Cours.Professeurs','Cours.Groupes.Promotions'],
                'conditions' => ['Promotions.annee_id' => $etab->annee_id,'Groupes.id' => $id, 'Professeurs.id'=>$prof->id]
            ]);
            $groupe = $this->Devoirs->Cours->Groupes->get($id);
        }

        $this->set(compact('devoirs','cours','periodes','groupe'));
    }

    public function fiche($id = null)
    {
        $devoir = $this->Devoirs->get($id, [
            'contain' => ['Cours.Matieres','Cours.Professeurs','Cours.Groupes.Affectations.Inscriptions.Eleves','Periodes','DevoirNotes',
            'Cours.Groupes.Affectations.Inscriptions'=>['conditions'=> ['Inscriptions.etat !='=>'suspendu']]
            ]
        ]);
        
        $this->set(compact('devoir'));
    }

    public function editerContenu($id){
        $devoir = $this->Devoirs->get($id);
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $devoir = $this->Devoirs->patchEntity($devoir,$temp);
            //dd($this->request->getData());
            if (!$this->Devoirs->save($devoir)) {
                $this->Flash->error(__("Le contenu n'a pu être mise à jour. Merci de réessayer."));
            }
        }
        return $this->redirect(['action' => 'fiche', $devoir->id]);
    }

    public function modifierDetails($id){
        $devoir = $this->Devoirs->get($id);
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $temp['date'] .= ' '.$temp['heure'];
            $devoir = $this->Devoirs->patchEntity($devoir,$temp);
            //dd($this->request->getData());
            if (!$this->Devoirs->save($devoir)) {
                $this->Flash->error(__("Les détails n'ont pu être mis à jour. Merci de réessayer."));
            }
        }
        return $this->redirect(['action' => 'fiche', $devoir->id]);
    }

    public function supprimer($id){
        $devoir = $this->Devoirs->get($id,["contain"=>['Periodes','DevoirNotes']]);
        if ($this->request->is('post')) {
            if($devoir->periode->statut == 'clôturé'){
                $this->Flash->error(__("Le devoir ne pu être supprimée. Le ".$devoir->periode->nom." a été fermé."));
            }
            if (sizeof($devoir->devoir_notes)>0) {
                $this->Devoirs->DevoirNotes->deleteAll(['devoir_id'=>$devoir->id]);
            }
            if (!$this->Devoirs->delete($devoir)) {
                $this->Flash->error(__("Le devoir n'a pu être supprimée. Merci de réessayer."));
            }
        }
        return $this->redirect(['action' => 'index']);
    }

    public function editerNotes($devoir_id){
        $this->loadModel('DevoirNotes');
        if ($this->request->is('post')) { 
            $temp = $this->request->getData();
            foreach($temp['notes'] as $note){
                if($note['note']=='') continue;
                $not = $this->DevoirNotes->find('all',
                    ['conditions' => ['DevoirNotes.eleve_id' => $note['eleve_id'],'DevoirNotes.devoir_id'=> $devoir_id]
                ])->first();
                if($not==null) $not = $this->DevoirNotes->newEntity();
                $not->note = $note['note'];
                $not->eleve_id = $note['eleve_id'];
                $not->devoir_id = $devoir_id;
                $this->DevoirNotes->save($not);
            }
        }
        return $this->redirect(['action' => 'fiche', $devoir_id]);
    }

    public function editerPj(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $id = $temp['id'];
            $pj = $temp['pj'];
            $extensions = array("pdf", "doc", "docx","ppt","pptx");
            $url = $this->definirPj($pj,$extensions,'devoirs',$id);
            if(!$url){  
                $this->Flash->error(__("Le document n'a pu être modifiée. Merci de réessayer."));
            }else{
                $devoir = $this->Devoirs->get($id);
                $devoir->pj = $url;
                $this->Devoirs->save($devoir);
            }
            return $this->redirect($this->referer());
        }
    }
}
