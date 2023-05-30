<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Professeurs Controller
 *
 * @property \App\Model\Table\ProfesseursTable $Professeurs
 *
 * @method \App\Model\Entity\Professeur[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProfesseursController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $professeurs = $this->paginate($this->Professeurs);

        $this->set(compact('professeurs'));
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
    public function add()
    {
        $professeur = $this->Professeurs->newEntity();
        if ($this->request->is('post')) {
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
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $professeur = $this->Professeurs->get($id);
        if ($this->Professeurs->delete($professeur)) {
            $this->Flash->success(__('The professeur has been deleted.'));
        } else {
            $this->Flash->error(__('The professeur could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
