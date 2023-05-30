<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Desserts Controller
 *
 * @property \App\Model\Table\DessertsTable $Desserts
 *
 * @method \App\Model\Entity\Dessert[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DessertsController extends AppController
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
        $desserts = $this->paginate($this->Desserts);

        $this->set(compact('desserts'));
    }

    /**
     * View method
     *
     * @param string|null $id Dessert id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $dessert = $this->Desserts->get($id, [
            'contain' => ['Etablissements', 'Menus']
        ]);

        $this->set('dessert', $dessert);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $dessert = $this->Desserts->newEntity();
        if ($this->request->is('post')) {
            $dessert = $this->Desserts->patchEntity($dessert, $this->request->getData());
            if ($this->Desserts->save($dessert)) {
                $this->Flash->success(__('The dessert has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The dessert could not be saved. Please, try again.'));
        }
        $etablissements = $this->Desserts->Etablissements->find('list', ['limit' => 200]);
        $this->set(compact('dessert', 'etablissements'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Dessert id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $dessert = $this->Desserts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dessert = $this->Desserts->patchEntity($dessert, $this->request->getData());
            if ($this->Desserts->save($dessert)) {
                $this->Flash->success(__('The dessert has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The dessert could not be saved. Please, try again.'));
        }
        $etablissements = $this->Desserts->Etablissements->find('list', ['limit' => 200]);
        $this->set(compact('dessert', 'etablissements'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Dessert id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $dessert = $this->Desserts->get($id);
        if ($this->Desserts->delete($dessert)) {
            $this->Flash->success(__('The dessert has been deleted.'));
        } else {
            $this->Flash->error(__('The dessert could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
