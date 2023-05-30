<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Factures Controller
 *
 * @property \App\Model\Table\FacturesTable $Factures
 *
 * @method \App\Model\Entity\Facture[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FacturesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Mois']
        ];
        $factures = $this->paginate($this->Factures);

        $this->set(compact('factures'));
    }

    /**
     * View method
     *
     * @param string|null $id Facture id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $facture = $this->Factures->get($id, [
            'contain' => ['Mois', 'Reglements']
        ]);

        $this->set('facture', $facture);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $facture = $this->Factures->newEntity();
        if ($this->request->is('post')) {
            $facture = $this->Factures->patchEntity($facture, $this->request->getData());
            if ($this->Factures->save($facture)) {
                $this->Flash->success(__('The facture has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The facture could not be saved. Please, try again.'));
        }
        $mois = $this->Factures->Mois->find('list', ['limit' => 200]);
        $this->set(compact('facture', 'mois'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Facture id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $facture = $this->Factures->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $facture = $this->Factures->patchEntity($facture, $this->request->getData());
            if ($this->Factures->save($facture)) {
                $this->Flash->success(__('The facture has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The facture could not be saved. Please, try again.'));
        }
        $mois = $this->Factures->Mois->find('list', ['limit' => 200]);
        $this->set(compact('facture', 'mois'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Facture id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $facture = $this->Factures->get($id);
        if ($this->Factures->delete($facture)) {
            $this->Flash->success(__('The facture has been deleted.'));
        } else {
            $this->Flash->error(__('The facture could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
