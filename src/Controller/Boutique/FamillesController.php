<?php
namespace App\Controller\Boutique;

use App\Controller\AppController;
use Cake\Event\Event;
use cake\Routing\Router;

class FamillesController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('boutique');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $etab = $this->getEtablissement();

        $familles = $this->Familles->find('all',[
            'conditions' => ['Familles.etablissement_id' => $etab->id],
            'order' => ['Familles.libelle'=>'ASC']
        ]);

        $this->set(compact('familles'));
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
        $famille = $this->Familles->get($id, [
            'contain' => ['produits.VLignes']
        ]);

        $this->set('famille', $famille);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function ajouter()
    {
        if ($this->request->is('post')) {
            $famille = $this->Familles->newEntity();
            $temp = $this->request->getData();
            $famille = $this->Familles->patchEntity($famille, $temp);
            if ($this->Familles->save($famille)) {
                $this->Flash->success(__("La famille a été bien enregistrée."));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__("La famille n'a pu être enregistrée. Merci de réessayer."));
        }
        return $this->redirect($this->referer());
    }

    public function modifier()
    {
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $famille = $this->Familles->get($temp['id']);
            $famille = $this->Familles->patchEntity($famille, $temp);
            if ($this->Familles->save($famille)) {
                $this->Flash->success(__("La famille a été bien enregistrée."));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__("La famille n'a pu être enregistrée. Merci de réessayer."));
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

            $famille = $this->Familles->get($id);
            if ($this->Familles->delete($famille)) {
                $this->Flash->success(__("La famille été bien supprimée."));
            } else {
                $this->Flash->error(__("La famille n'a pu être supprimée. Merci de réessayer."));
            }
        }catch(\Exception $e){
            $this->Flash->error(__("Impossible d'effectuer la suppression!"));
        }
        return $this->redirect($this->referer());
    }
}