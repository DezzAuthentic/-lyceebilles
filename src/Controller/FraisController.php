<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Frais Controller
 *
 * @property \App\Model\Table\FraisTable $Frais
 *
 * @method \App\Model\Entity\Frai[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FraisController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Promotions', 'Types']
        ];
        $frais = $this->paginate($this->Frais);

        $this->set(compact('frais'));
    }

    /**
     * View method
     *
     * @param string|null $id Frai id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $frai = $this->Frais->get($id, [
            'contain' => ['Promotions', 'Types']
        ]);

        $this->set('frai', $frai);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $frai = $this->Frais->newEntity();
        if ($this->request->is('post')) {
            $frai = $this->Frais->patchEntity($frai, $this->request->getData());
            if ($this->Frais->save($frai)) {
                $this->Flash->success(__('The frai has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The frai could not be saved. Please, try again.'));
        }
        $promotions = $this->Frais->Promotions->find('list', ['limit' => 200]);
        $types = $this->Frais->Types->find('list', ['limit' => 200]);
        $this->set(compact('frai', 'promotions', 'types'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Frai id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $frai = $this->Frais->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $frai = $this->Frais->patchEntity($frai, $this->request->getData());
            if ($this->Frais->save($frai)) {
                $this->Flash->success(__('The frai has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The frai could not be saved. Please, try again.'));
        }
        $promotions = $this->Frais->Promotions->find('list', ['limit' => 200]);
        $types = $this->Frais->Types->find('list', ['limit' => 200]);
        $this->set(compact('frai', 'promotions', 'types'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Frai id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $frai = $this->Frais->get($id);
        if ($this->Frais->delete($frai)) {
            $this->Flash->success(__('The frai has been deleted.'));
        } else {
            $this->Flash->error(__('The frai could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
