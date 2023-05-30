<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Enseignees Controller
 *
 * @property \App\Model\Table\EnseigneesTable $Enseignees
 *
 * @method \App\Model\Entity\Enseignee[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EnseigneesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Matieres', 'Professeurs']
        ];
        $enseignees = $this->paginate($this->Enseignees);

        $this->set(compact('enseignees'));
    }

    /**
     * View method
     *
     * @param string|null $id Enseignee id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $enseignee = $this->Enseignees->get($id, [
            'contain' => ['Matieres', 'Professeurs']
        ]);

        $this->set('enseignee', $enseignee);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $enseignee = $this->Enseignees->newEntity();
        if ($this->request->is('post')) {
            $enseignee = $this->Enseignees->patchEntity($enseignee, $this->request->getData());
            if ($this->Enseignees->save($enseignee)) {
                $this->Flash->success(__('The enseignee has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The enseignee could not be saved. Please, try again.'));
        }
        $matieres = $this->Enseignees->Matieres->find('list', ['limit' => 200]);
        $professeurs = $this->Enseignees->Professeurs->find('list', ['limit' => 200]);
        $this->set(compact('enseignee', 'matieres', 'professeurs'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Enseignee id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $enseignee = $this->Enseignees->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $enseignee = $this->Enseignees->patchEntity($enseignee, $this->request->getData());
            if ($this->Enseignees->save($enseignee)) {
                $this->Flash->success(__('The enseignee has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The enseignee could not be saved. Please, try again.'));
        }
        $matieres = $this->Enseignees->Matieres->find('list', ['limit' => 200]);
        $professeurs = $this->Enseignees->Professeurs->find('list', ['limit' => 200]);
        $this->set(compact('enseignee', 'matieres', 'professeurs'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Enseignee id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $enseignee = $this->Enseignees->get($id);
        if ($this->Enseignees->delete($enseignee)) {
            $this->Flash->success(__('The enseignee has been deleted.'));
        } else {
            $this->Flash->error(__('The enseignee could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
