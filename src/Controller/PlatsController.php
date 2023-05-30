<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Plats Controller
 *
 * @property \App\Model\Table\PlatsTable $Plats
 *
 * @method \App\Model\Entity\Plat[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PlatsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Etablissements']
        ];
        $plats = $this->paginate($this->Plats);

        $this->set(compact('plats'));
    }

    /**
     * View method
     *
     * @param string|null $id Plat id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $plat = $this->Plats->get($id, [
            'contain' => ['Etablissements', 'Menus']
        ]);

        $this->set('plat', $plat);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $plat = $this->Plats->newEntity();
        if ($this->request->is('post')) {
            $plat = $this->Plats->patchEntity($plat, $this->request->getData());
            if ($this->Plats->save($plat)) {
                $this->Flash->success(__('The plat has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The plat could not be saved. Please, try again.'));
        }
        $etablissements = $this->Plats->Etablissements->find('list', ['limit' => 200]);
        $this->set(compact('plat', 'etablissements'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Plat id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $plat = $this->Plats->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $plat = $this->Plats->patchEntity($plat, $this->request->getData());
            if ($this->Plats->save($plat)) {
                $this->Flash->success(__('The plat has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The plat could not be saved. Please, try again.'));
        }
        $etablissements = $this->Plats->Etablissements->find('list', ['limit' => 200]);
        $this->set(compact('plat', 'etablissements'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Plat id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $plat = $this->Plats->get($id);
        if ($this->Plats->delete($plat)) {
            $this->Flash->success(__('The plat has been deleted.'));
        } else {
            $this->Flash->error(__('The plat could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
