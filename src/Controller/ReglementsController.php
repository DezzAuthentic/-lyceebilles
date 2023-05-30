<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Reglements Controller
 *
 * @property \App\Model\Table\ReglementsTable $Reglements
 *
 * @method \App\Model\Entity\Reglement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReglementsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Factures', 'Users']
        ];
        $reglements = $this->paginate($this->Reglements);

        $this->set(compact('reglements'));
    }

    /**
     * View method
     *
     * @param string|null $id Reglement id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $reglement = $this->Reglements->get($id, [
            'contain' => ['Factures', 'Users']
        ]);

        $this->set('reglement', $reglement);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $reglement = $this->Reglements->newEntity();
        if ($this->request->is('post')) {
            $reglement = $this->Reglements->patchEntity($reglement, $this->request->getData());
            if ($this->Reglements->save($reglement)) {
                $this->Flash->success(__('The reglement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reglement could not be saved. Please, try again.'));
        }
        $factures = $this->Reglements->Factures->find('list', ['limit' => 200]);
        $users = $this->Reglements->Users->find('list', ['limit' => 200]);
        $this->set(compact('reglement', 'factures', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Reglement id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $reglement = $this->Reglements->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $reglement = $this->Reglements->patchEntity($reglement, $this->request->getData());
            if ($this->Reglements->save($reglement)) {
                $this->Flash->success(__('The reglement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reglement could not be saved. Please, try again.'));
        }
        $factures = $this->Reglements->Factures->find('list', ['limit' => 200]);
        $users = $this->Reglements->Users->find('list', ['limit' => 200]);
        $this->set(compact('reglement', 'factures', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Reglement id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $reglement = $this->Reglements->get($id);
        if ($this->Reglements->delete($reglement)) {
            $this->Flash->success(__('The reglement has been deleted.'));
        } else {
            $this->Flash->error(__('The reglement could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
