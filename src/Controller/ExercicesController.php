<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Exercices Controller
 *
 * @property \App\Model\Table\ExercicesTable $Exercices
 *
 * @method \App\Model\Entity\Exercice[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ExercicesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Seances']
        ];
        $exercices = $this->paginate($this->Exercices);

        $this->set(compact('exercices'));
    }

    /**
     * View method
     *
     * @param string|null $id Exercice id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $exercice = $this->Exercices->get($id, [
            'contain' => ['Seances']
        ]);

        $this->set('exercice', $exercice);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $exercice = $this->Exercices->newEntity();
        if ($this->request->is('post')) {
            $exercice = $this->Exercices->patchEntity($exercice, $this->request->getData());
            if ($this->Exercices->save($exercice)) {
                $this->Flash->success(__('The exercice has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The exercice could not be saved. Please, try again.'));
        }
        $seances = $this->Exercices->Seances->find('list', ['limit' => 200]);
        $this->set(compact('exercice', 'seances'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Exercice id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $exercice = $this->Exercices->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $exercice = $this->Exercices->patchEntity($exercice, $this->request->getData());
            if ($this->Exercices->save($exercice)) {
                $this->Flash->success(__('The exercice has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The exercice could not be saved. Please, try again.'));
        }
        $seances = $this->Exercices->Seances->find('list', ['limit' => 200]);
        $this->set(compact('exercice', 'seances'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Exercice id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $exercice = $this->Exercices->get($id);
        if ($this->Exercices->delete($exercice)) {
            $this->Flash->success(__('The exercice has been deleted.'));
        } else {
            $this->Flash->error(__('The exercice could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
