<?php
namespace App\Controller\Boutique;

use App\Controller\AppController;
use Cake\Event\Event;
use cake\Routing\Router;

class ProduitsController extends AppController
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

        $produits = $this->Produits->find('all',[
            'contain' => ['Familles'],
            'conditions' => ['Familles.etablissement_id' => $etab->id],
            'order' => ['Produits.libelle'=>'ASC']
        ]);

        $familles = $this->Produits->Familles->find('list',[
            'conditions' => ['Familles.etablissement_id' => $etab->id]
        ]);

        $this->set(compact('produits','familles'));
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
        $produit = $this->Produits->get($id, [
            'contain' => ['Familles', 'VLignes']
        ]);

        $this->set('produit', $produit);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function ajouter()
    {
        if ($this->request->is('post')) {
            $produit = $this->Produits->newEntity();
            $temp = $this->request->getData();
            $produit = $this->Produits->patchEntity($produit, $temp);
            if ($this->Produits->save($produit)) {
                $this->Flash->success(__("Le produit a été bien enregistré."));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__("Le produit n'a pu être enregistré. Merci de réessayer."));
        }
        return $this->redirect($this->referer());
    }

    public function modifier()
    {
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $produit = $this->Produits->get($temp['id']);
            $produit = $this->Produits->patchEntity($produit, $temp);
            if ($this->Produits->save($produit)) {
                $this->Flash->success(__("Le produit a été bien enregistré."));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__("Le produit n'a pu être enregistré. Merci de réessayer."));
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

            $produit = $this->Produits->get($id);
            if ($this->Produits->delete($produit)) {
                $this->Flash->success(__("Le produit  été bien supprimé."));
            } else {
                $this->Flash->error(__("Le produit n'a pu être supprimé. Merci de réessayer."));
            }
        }catch(\Exception $e){
            $this->Flash->error(__("Impossible d'effectuer la suppression!"));
        }
        return $this->redirect($this->referer());
    }
}