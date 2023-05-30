<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Devoirs Controller
 *
 * @property \App\Model\Table\DevoirsTable $Devoirs
 *
 * @method \App\Model\Entity\Devoir[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DevoirsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Cours']
        ];
        $devoirs = $this->paginate($this->Devoirs);

        $this->set(compact('devoirs'));
    }

    /**
     * View method
     *
     * @param string|null $id Devoir id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $devoir = $this->Devoirs->get($id, [
            'contain' => ['Cours', 'DevoirNotes']
        ]);

        $this->set('devoir', $devoir);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $devoir = $this->Devoirs->newEntity();
        if ($this->request->is('post')) {
            $devoir = $this->Devoirs->patchEntity($devoir, $this->request->getData());
            if ($this->Devoirs->save($devoir)) {
                $this->Flash->success(__('The devoir has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The devoir could not be saved. Please, try again.'));
        }
        $cours = $this->Devoirs->Cours->find('list', ['limit' => 200]);
        $this->set(compact('devoir', 'cours'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Devoir id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $devoir = $this->Devoirs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $devoir = $this->Devoirs->patchEntity($devoir, $this->request->getData());
            if ($this->Devoirs->save($devoir)) {
                $this->Flash->success(__('The devoir has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The devoir could not be saved. Please, try again.'));
        }
        $cours = $this->Devoirs->Cours->find('list', ['limit' => 200]);
        $this->set(compact('devoir', 'cours'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Devoir id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $devoir = $this->Devoirs->get($id);
        if ($this->Devoirs->delete($devoir)) {
            $this->Flash->success(__('The devoir has been deleted.'));
        } else {
            $this->Flash->error(__('The devoir could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
