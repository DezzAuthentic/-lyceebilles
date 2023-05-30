<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Tuteurs Controller
 *
 * @property \App\Model\Table\TuteursTable $Tuteurs
 *
 * @method \App\Model\Entity\Tuteur[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TuteursController extends AppController
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
        $tuteurs = $this->paginate($this->Tuteurs);

        $this->set(compact('tuteurs'));
    }

    /**
     * View method
     *
     * @param string|null $id Tuteur id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tuteur = $this->Tuteurs->get($id, [
            'contain' => ['Users', 'Demandes', 'Eleves']
        ]);

        $this->set('tuteur', $tuteur);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tuteur = $this->Tuteurs->newEntity();
        if ($this->request->is('post')) {
            $tuteur = $this->Tuteurs->patchEntity($tuteur, $this->request->getData());
            if ($this->Tuteurs->save($tuteur)) {
                $this->Flash->success(__('The tuteur has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tuteur could not be saved. Please, try again.'));
        }
        $users = $this->Tuteurs->Users->find('list', ['limit' => 200]);
        $this->set(compact('tuteur', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tuteur id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tuteur = $this->Tuteurs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tuteur = $this->Tuteurs->patchEntity($tuteur, $this->request->getData());
            if ($this->Tuteurs->save($tuteur)) {
                $this->Flash->success(__('The tuteur has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tuteur could not be saved. Please, try again.'));
        }
        $users = $this->Tuteurs->Users->find('list', ['limit' => 200]);
        $this->set(compact('tuteur', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tuteur id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tuteur = $this->Tuteurs->get($id);
        if ($this->Tuteurs->delete($tuteur)) {
            $this->Flash->success(__('The tuteur has been deleted.'));
        } else {
            $this->Flash->error(__('The tuteur could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
