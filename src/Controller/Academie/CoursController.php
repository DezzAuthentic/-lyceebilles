<?php
namespace App\Controller\Academie;

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
        $this->viewBuilder()->setLayout('academie');
    }
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function ajouter()
    {
        if ($this->request->is('post')) {
            $cour = $this->Cours->newEntity();
            $cour = $this->Cours->patchEntity($cour, $this->request->getData());
            if (!$this->Cours->save($cour)) {
                $this->Flash->error(__("Le cours n'a pu être enregistré. Merci de réessayer."));
            }
        }
        $this->redirect($this->referer());
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
        $periodes = $this->Periodes->find('list',[
            'conditions' => ['Periodes.annee_id' => $etab->annee_id, 'Periodes.statut !='=>'clôturé']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cours = $this->Cours->patchEntity($cours, $this->request->getData());
            if ($this->Cours->save($cours)) {
                $this->Flash->success(__('Présentation mise à jour avec succès.'));
            } else $this->Flash->error(__("La présentation n'a pu être mise à jour. Merci de réessayer."));
        }
        
        $this->set(compact('cours','periodes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Cour id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function supprimer($id){
        try{
            if ($this->request->is('post')) {
                $cour = $this->Cours->get($id);
                if (!$this->Cours->delete($cour)) {
                    $this->Flash->error(__("La suppression n'a pu être faite. Merci de réessayer."));
                }
                return $this->redirect($this->referer());
            }
        }catch(\Exception $e){
            $this->Flash->error(__("Impossible d'effectuer la suppression!"));
        }
        return $this->redirect($this->referer());
    }

    public function classe($id=null){
        $etab = $this->getEtablissement();
        $groupe = null;

        if($id==null){
            $cours = $this->Cours->find('all',[
                'contain' => ['Matieres','Professeurs','Groupes.Promotions','Seances.Presences','Edt'],
                'conditions' => ['Promotions.annee_id' => $etab->annee_id]
            ]);
        }else{
            $cours = $this->Cours->find('all',[
                'contain' => ['Matieres','Professeurs','Groupes.Promotions','Seances.Presences','Edt'],
                'conditions' => ['Promotions.annee_id' => $etab->annee_id,'Groupes.id' => $id]
            ]);
            $groupe = $this->Cours->Groupes->get($id);
        }
        
        $this->set(compact('cours','groupe'));
    }

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

    public function editerPj(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $id = $temp['id'];
            $pj = $temp['pj'];
            $extensions = array("pdf", "doc", "docx","ppt","pptx");
            $url = $this->definirPj($pj,$extensions,'cours',$id);
            if(!$url){  
                $this->Flash->error(__("Le document n'a pu être modifiée. Merci de réessayer."));
            }else{
                $cours = $this->Cours->get($id);
                $cours->pj = $url;
                $this->Cours->save($cours);
            }
            return $this->redirect($this->referer());
        }
    }
}
