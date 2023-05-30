<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Edt Controller
 *
 * @property \App\Model\Table\EdtTable $Edt
 *
 * @method \App\Model\Entity\Edt[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EdtController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Salles', 'Cours']
        ];
        $edt = $this->paginate($this->Edt);

        $this->set(compact('edt'));
    }

    /**
     * View method
     *
     * @param string|null $id Edt id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $edt = $this->Edt->get($id, [
            'contain' => ['Salles', 'Cours']
        ]);

        $this->set('edt', $edt);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $edt = $this->Edt->newEntity();
        if ($this->request->is('post')) {
            $edt = $this->Edt->patchEntity($edt, $this->request->getData());
            if ($this->Edt->save($edt)) {
                $this->Flash->success(__('The edt has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The edt could not be saved. Please, try again.'));
        }
        $salles = $this->Edt->Salles->find('list', ['limit' => 200]);
        $cours = $this->Edt->Cours->find('list', ['limit' => 200]);
        $this->set(compact('edt', 'salles', 'cours'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Edt id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $edt = $this->Edt->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $edt = $this->Edt->patchEntity($edt, $this->request->getData());
            if ($this->Edt->save($edt)) {
                $this->Flash->success(__('The edt has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The edt could not be saved. Please, try again.'));
        }
        $salles = $this->Edt->Salles->find('list', ['limit' => 200]);
        $cours = $this->Edt->Cours->find('list', ['limit' => 200]);
        $this->set(compact('edt', 'salles', 'cours'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Edt id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $edt = $this->Edt->get($id);
        if ($this->Edt->delete($edt)) {
            $this->Flash->success(__('The edt has been deleted.'));
        } else {
            $this->Flash->error(__('The edt could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
