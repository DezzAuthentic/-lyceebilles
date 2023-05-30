<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Evenements Controller
 *
 * @property \App\Model\Table\EvenementsTable $Evenements
 *
 * @method \App\Model\Entity\Evenement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EvenementsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $evenements = $this->paginate($this->Evenements);

        $this->set(compact('evenements'));
    }

    /**
     * View method
     *
     * @param string|null $id Evenement id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $evenement = $this->Evenements->get($id, [
            'contain' => []
        ]);

        $this->set('evenement', $evenement);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $evenement = $this->Evenements->newEntity();
        if ($this->request->is('post')) {
            $evenement = $this->Evenements->patchEntity($evenement, $this->request->getData());
            if ($this->Evenements->save($evenement)) {
                $this->Flash->success(__('The evenement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The evenement could not be saved. Please, try again.'));
        }
        $this->set(compact('evenement'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Evenement id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $evenement = $this->Evenements->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $evenement = $this->Evenements->patchEntity($evenement, $this->request->getData());
            if ($this->Evenements->save($evenement)) {
                $this->Flash->success(__('The evenement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The evenement could not be saved. Please, try again.'));
        }
        $this->set(compact('evenement'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Evenement id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $evenement = $this->Evenements->get($id);
        if ($this->Evenements->delete($evenement)) {
            $this->Flash->success(__('The evenement has been deleted.'));
        } else {
            $this->Flash->error(__('The evenement could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
