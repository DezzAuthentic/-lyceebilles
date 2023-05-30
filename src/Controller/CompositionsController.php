<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Compositions Controller
 *
 * @property \App\Model\Table\CompositionsTable $Compositions
 *
 * @method \App\Model\Entity\Composition[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CompositionsController extends AppController
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
        $compositions = $this->paginate($this->Compositions);

        $this->set(compact('compositions'));
    }

    /**
     * View method
     *
     * @param string|null $id Composition id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $composition = $this->Compositions->get($id, [
            'contain' => ['Cours']
        ]);

        $this->set('composition', $composition);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $composition = $this->Compositions->newEntity();
        if ($this->request->is('post')) {
            $composition = $this->Compositions->patchEntity($composition, $this->request->getData());
            if ($this->Compositions->save($composition)) {
                $this->Flash->success(__('The composition has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The composition could not be saved. Please, try again.'));
        }
        $cours = $this->Compositions->Cours->find('list', ['limit' => 200]);
        $this->set(compact('composition', 'cours'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Composition id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $composition = $this->Compositions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $composition = $this->Compositions->patchEntity($composition, $this->request->getData());
            if ($this->Compositions->save($composition)) {
                $this->Flash->success(__('The composition has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The composition could not be saved. Please, try again.'));
        }
        $cours = $this->Compositions->Cours->find('list', ['limit' => 200]);
        $this->set(compact('composition', 'cours'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Composition id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $composition = $this->Compositions->get($id);
        if ($this->Compositions->delete($composition)) {
            $this->Flash->success(__('The composition has been deleted.'));
        } else {
            $this->Flash->error(__('The composition could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
