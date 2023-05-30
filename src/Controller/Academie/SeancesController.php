<?php
namespace App\Controller\Academie;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Seances Controller
 *
 * @property \App\Model\Table\SeancesTable $Seances
 *
 * @method \App\Model\Entity\Seance[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SeancesController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('academie');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */

    public function index(){
        $this->loadModel('Groupes');
        $etab = $this->getEtablissement();

        $groupes = $this->Groupes->find('all',[
            'contain' => ['Promotions.Niveaux','Affectations','Promotions.Inscriptions'],
            'conditions' => ['Promotions.annee_id'=> $etab->annee_id],
            'order' => ['Niveaux.ordre' => 'ASC']
        ]);
        $groupes = $groupes->toArray();
        $effectifs = Array();
        $promo_id = null;

        //Calcul de l'effectif de chaque niveau
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

    public function classe($id=null)
    {
        $etab = $this->getEtablissement();
        $groupe = null;

        if($id==null){
            $seances = $this->Seances->find('all',[
                'contain' => ['Cours.Matieres','Cours.Professeurs','Cours.Groupes.Promotions','Presences'],
                'conditions' => ['Promotions.annee_id' => $etab->annee_id]
            ]);
        }else{
            $seances = $this->Seances->find('all',[
                'contain' => ['Cours.Matieres','Cours.Professeurs','Cours.Groupes.Promotions','Presences'],
                'conditions' => ['Promotions.annee_id' => $etab->annee_id,'Groupes.id' => $id]
            ]);
            $groupe = $this->Seances->Cours->Groupes->get($id);
        }

        $this->set(compact('seances','groupe'));
    }

    /**
     * View method
     *
     * @param string|null $id Seance id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function fiche($id = null)
    {
        $seance = $this->Seances->get($id, [
            'contain' => ['Cours.Matieres','Cours.Professeurs','Cours.Groupes.Affectations.Inscriptions.Eleves','Exercices','Presences',
                'Cours.Groupes.Affectations.Inscriptions'=>['conditions'=> ['Inscriptions.etat !='=>'suspendu']]]
        ]);

        $this->set('seance', $seance);
    }

    public function demarrer(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $cours_id = $temp['cours_id'];
            if($this->brouillon($cours_id)>0){
                $this->Flash->error(__("Une séance de ce cours est déjà à l'état brouillon. Veuillez la valider ou la supprimer."));
                return $this->redirect($this->referer());
            } 
            $seance = $this->Seances->newEntity();
            $seance = $this->Seances->patchEntity($seance, $temp);
            $seance->etat = 'brouillon';
            if(!$this->Seances->save($seance)){
                $this->Flash->error(__("La séance n'a pu démarrer. Merci de réessayer."));
                return $this->redirect($this->referer());
            }
            return $this->redirect(['action' => 'fiche', $seance->id]);
        }
    }

    public function brouillon($cours_id){
        $seances = $this->Seances->find('all',[
            'conditions' => ["Seances.cours_id" => $cours_id, 'Seances.etat' => "brouillon"]
        ]);
        return $seances->count();
    }

    public function editerContenu($id){
        $seance = $this->Seances->get($id);
        if ($this->request->is('post')) {
            $seance = $this->Seances->patchEntity($seance, $this->request->getData());
            //dd($this->request->getData());
            if (!$this->Seances->save($seance)) {
                $this->Flash->error(__("La présentation n'a pu être mise à jour. Merci de réessayer."));
            }
        }
        return $this->redirect(['action' => 'fiche', $seance->id]);
    }

    public function modifierDetails($id){
        $seance = $this->Seances->get($id);
        if ($this->request->is('post')) {
            $seance = $this->Seances->patchEntity($seance, $this->request->getData());
            //dd($this->request->getData());
            if (!$this->Seances->save($seance)) {
                $this->Flash->error(__("Les détails n'ont pu être mis à jour. Merci de réessayer."));
            }
        }
        return $this->redirect(['action' => 'fiche', $seance->id]);
    }

    public function supprimer($id){
        $seance = $this->Seances->get($id);
        if ($this->request->is('post')) {
            if($seance->etat != "brouillon"){
                $this->Flash->error(__("Cette séance ne peut être supprimée. Elle a été validée"));
                return $this->redirect($this->referer());
            } 
            $this->Seances->Presences->deleteAll(['Presences.seance_id'=>$id]);
            if (!$this->Seances->delete($seance)) {
                $this->Flash->error(__("La séance n'a pu être supprimée. Merci de réessayer."));
            }
        }
        return $this->redirect(['action' => 'index']);
    }
    public function valider($id){
        $seance = $this->Seances->get($id);
        if ($this->request->is('post')) { 
            $seance->etat = 'validé';
            if (!$this->Seances->save($seance)) {
                $this->Flash->error(__("La séance n'a pu être validée. Merci de réessayer."));
            }
        }
        return $this->redirect(['action' => 'fiche', $seance->id]);
    }

    public function retournerEnBrouillon($id){
        $seance = $this->Seances->get($id);
        if($this->brouillon($seance->cours_id)>0){
            $this->Flash->error(__("Une séance de ce cours est déjà à l'état brouillon. Veuillez la valider ou la supprimer."));
            return $this->redirect($this->referer());
        } 
        if ($this->request->is('post')) { 
            $seance->etat = 'brouillon';
            if (!$this->Seances->save($seance)) {
                $this->Flash->error(__("L'état de la séance n'a pu être retourné en brouillon. Merci de réessayer."));
            }
        }
        return $this->redirect(['action' => 'fiche', $seance->id]);
    }

    public function editerPresences($seance_id){
        $this->loadModel('Presences');
        if ($this->request->is('post')) { 
            $temp = $this->request->getData();
            foreach($temp['presences'] as $presence){
                if($presence['type'] != 'presence'){
                    $pres = $this->Presences->find('all',
                        ['conditions' => ['Presences.eleve_id' => $presence['eleve_id'],'Presences.seance_id'=> $seance_id]
                    ])->first();
                    if($pres==null)$pres = $this->Presences->newEntity();
                    $pres->type = $presence['type'];
                    $pres->eleve_id = $presence['eleve_id'];
                    $pres->seance_id = $seance_id;
                    $this->Presences->save($pres);
                }
            }
        }
        return $this->redirect(['action' => 'fiche', $seance_id]);
    }

    public function editerPj(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $id = $temp['id'];
            $pj = $temp['pj'];
            $extensions = array("pdf", "doc", "docx","ppt","pptx");
            $url = $this->definirPj($pj,$extensions,'seances',$id);
            if(!$url){  
                $this->Flash->error(__("Le document n'a pu être modifiée. Merci de réessayer."));
            }else{
                $seance = $this->Seances->get($id);
                $seance->pj = $url;
                $this->Seances->save($seance);
            }
            return $this->redirect($this->referer());
        }
    }
    
}
