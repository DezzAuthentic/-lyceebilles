<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Emprunts Controller
 *
 * @property \App\Model\Table\EmpruntsTable $Emprunts
 *
 * @method \App\Model\Entity\Emprunt[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmpruntsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Ouvrages']
        ];
        $emprunts = $this->paginate($this->Emprunts);

        $this->set(compact('emprunts'));
    }

    /**
     * View method
     *
     * @param string|null $id Emprunt id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $emprunt = $this->Emprunts->get($id, [
            'contain' => ['Users', 'Ouvrages']
        ]);

        $this->set('emprunt', $emprunt);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $emprunt = $this->Emprunts->newEntity();
        if ($this->request->is('post')) {
            $emprunt = $this->Emprunts->patchEntity($emprunt, $this->request->getData());
            if ($this->Emprunts->save($emprunt)) {
                $this->Flash->success(__('The emprunt has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The emprunt could not be saved. Please, try again.'));
        }
        $users = $this->Emprunts->Users->find('list', ['limit' => 200]);
        $ouvrages = $this->Emprunts->Ouvrages->find('list', ['limit' => 200]);
        $this->set(compact('emprunt', 'users', 'ouvrages'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Emprunt id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $emprunt = $this->Emprunts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $emprunt = $this->Emprunts->patchEntity($emprunt, $this->request->getData());
            if ($this->Emprunts->save($emprunt)) {
                $this->Flash->success(__('The emprunt has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The emprunt could not be saved. Please, try again.'));
        }
        $users = $this->Emprunts->Users->find('list', ['limit' => 200]);
        $ouvrages = $this->Emprunts->Ouvrages->find('list', ['limit' => 200]);
        $this->set(compact('emprunt', 'users', 'ouvrages'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Emprunt id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $emprunt = $this->Emprunts->get($id);
        if ($this->Emprunts->delete($emprunt)) {
            $this->Flash->success(__('The emprunt has been deleted.'));
        } else {
            $this->Flash->error(__('The emprunt could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
