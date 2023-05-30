<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Demandes Controller
 *
 * @property \App\Model\Table\DemandesTable $Demandes
 *
 * @method \App\Model\Entity\Demande[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DemandesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Tuteurs']
        ];
        $demandes = $this->paginate($this->Demandes);

        $this->set(compact('demandes'));
    }

    /**
     * View method
     *
     * @param string|null $id Demande id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $demande = $this->Demandes->get($id, [
            'contain' => ['Tuteurs']
        ]);

        $this->set('demande', $demande);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $demande = $this->Demandes->newEntity();
        if ($this->request->is('post')) {
            $demande = $this->Demandes->patchEntity($demande, $this->request->getData());
            if ($this->Demandes->save($demande)) {
                $this->Flash->success(__('The demande has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The demande could not be saved. Please, try again.'));
        }
        $tuteurs = $this->Demandes->Tuteurs->find('list', ['limit' => 200]);
        $this->set(compact('demande', 'tuteurs'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Demande id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $demande = $this->Demandes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $demande = $this->Demandes->patchEntity($demande, $this->request->getData());
            if ($this->Demandes->save($demande)) {
                $this->Flash->success(__('The demande has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The demande could not be saved. Please, try again.'));
        }
        $tuteurs = $this->Demandes->Tuteurs->find('list', ['limit' => 200]);
        $this->set(compact('demande', 'tuteurs'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Demande id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $demande = $this->Demandes->get($id);
        if ($this->Demandes->delete($demande)) {
            $this->Flash->success(__('The demande has been deleted.'));
        } else {
            $this->Flash->error(__('The demande could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
