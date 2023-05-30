<?php
namespace App\Controller\Academie;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Event\Event;

/**
 * Professeurs Controller
 *
 * @property \App\Model\Table\ProfesseursTable $Professeurs
 *
 * @method \App\Model\Entity\Professeur[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProfesseursController extends AppController
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
    public function index()
    {
        $this->loadModel("Matieres");        
        $etab = $this->getEtablissement();

        $professeurs = $this->Professeurs->find('all',[
            'contain' => ['Enseignees.Matieres'],
            'conditions' => ['Professeurs.etablissement_id' => $etab->id],
            'order' => ['Professeurs.nom'=>'ASC','Professeurs.prenom'=>'ASC']
        ]);

        $matieres = $this->Matieres->find('all',[
            'conditions' => ['Matieres.etablissement_id' => $etab->id]
        ]);

        $this->set(compact('professeurs','matieres'));
    }

    /**
     * View method
     *
     * @param string|null $id Professeur id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $professeur = $this->Professeurs->get($id, [
            'contain' => ['Users', 'Cours', 'Enseignees']
        ]);

        $this->set('professeur', $professeur);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function ajouter()
    {
        if ($this->request->is('post')) {
            $nok=0;
            $professeur = $this->Professeurs->newEntity();
            $temp = $this->request->getData();
            $professeur = $this->Professeurs->patchEntity($professeur, $temp);
            if ($this->Professeurs->save($professeur)) {
                foreach($temp['matieres'] as $matiere){
                    $ens = $this->Professeurs->Enseignees->newEntity();
                    $ens->professeur_id = $professeur->id;
                    $ens->matiere_id = $matiere;
                    if(!$this->Professeurs->Enseignees->save($ens)) $nok++;
                }
                if($nok>0) $this->Flash->success(__("Certaines matières n'ont pu être confirmées."));
                $this->Flash->success(__("Le professeur a été bien enregistré."));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__("Le professeur n'a pu être enregistré. Merci de réessayer."));
        }
        return $this->redirect($this->referer());
    }

    public function modifier()
    {
        if ($this->request->is('post')) {
            $nok=0;
            $temp = $this->request->getData();
            $professeur = $this->Professeurs->get($temp['id']);
            $professeur = $this->Professeurs->patchEntity($professeur, $temp);
            if ($this->Professeurs->save($professeur)) {
                $this->Professeurs->Enseignees->deleteAll(['professeur_id'=>$professeur->id]);
                foreach($temp['matieres'] as $matiere){
                    $ens = $this->Professeurs->Enseignees->newEntity();
                    $ens->professeur_id = $professeur->id;
                    $ens->matiere_id = $matiere;
                    if(!$this->Professeurs->Enseignees->save($ens)) $nok++;
                }
                if($nok>0) $this->Flash->success(__("Certaines matières n'ont pu être confirmées."));
                $this->Flash->success(__("Le professeur a été bien enregistré."));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__("Le professeur n'a pu être enregistré. Merci de réessayer."));
        }
        return $this->redirect($this->referer());
    }

    /**
     * Edit method
     *
     * @param string|null $id Professeur id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $professeur = $this->Professeurs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $professeur = $this->Professeurs->patchEntity($professeur, $this->request->getData());
            if ($this->Professeurs->save($professeur)) {
                $this->Flash->success(__('The professeur has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The professeur could not be saved. Please, try again.'));
        }
        $users = $this->Professeurs->Users->find('list', ['limit' => 200]);
        $this->set(compact('professeur', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Professeur id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function supprimer($id = null)
    {
        try{
            $this->request->allowMethod(['post', 'delete']);

            $professeur = $this->Professeurs->get($id);
            $this->Professeurs->Enseignees->deleteAll(["professeur_id" => $id]);
            if ($this->Professeurs->delete($professeur)) {
                $this->Flash->success(__("Le professeur  été bien supprimé."));
            } else {
                $this->Flash->error(__("Le professeur n'a pu être supprimé. Merci de réessayer."));
            }
        }catch(\Exception $e){
            $this->Flash->error(__("Impossible d'effectuer la suppression!"));
        }
        return $this->redirect($this->referer());
    }

    public function principaux(){
        $this->loadModel("Matieres");        
        $etab = $this->getEtablissement();

        $professeurs = $this->Professeurs->find('all',[
            'contain' => ['Enseignees.Matieres'],
            'conditions' => ['Professeurs.etablissement_id' => $etab->id],
            'order' => ['Professeurs.nom'=>'ASC','Professeurs.prenom'=>'ASC']
        ]);

        $matieres = $this->Matieres->find('all',[
            'contain' => ['Professeurs'],
            'order' => ['Matieres.nom ASC'],
            'conditions' => ['Matieres.etablissement_id' => $etab->id]
        ]);

        $this->set(compact('professeurs','matieres'));
    }

    public function definirPrincipal(){
        $this->loadModel("Matieres");

        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            //dd($temp);
            $matiere = $this->Matieres->get($temp['id']);
            $matiere->professeur_id = $temp['professeur_id'];

            if($this->Matieres->save($matiere)){
                $this->Flash->success(__("Le professeur a été bien enregisté."));
            } else $this->Flash->error(__("Impossible d'enregistrer le professeur. Merci de réessayer!"));

        }
        return $this->redirect($this->referer());
    }

    public function retirerPrincipal($id = null)
    {
        $this->loadModel("Matieres");
        $matiere = $this->Matieres->get($id);
        $matiere->professeur_id = null;
        if($this->Matieres->save($matiere)){
            $this->Flash->success(__("Le professeur a été bien retiré."));
        } else $this->Flash->error(__("Impossible de retirer le professeur. Merci de réessayer!"));
        
        return $this->redirect($this->referer());
    }
}
