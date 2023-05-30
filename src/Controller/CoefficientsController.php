<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Coefficients Controller
 *
 * @property \App\Model\Table\CoefficientsTable $Coefficients
 *
 * @method \App\Model\Entity\Coefficient[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CoefficientsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Promotions', 'Niveaux', 'Series']
        ];
        $coefficients = $this->paginate($this->Coefficients);

        $this->set(compact('coefficients'));
    }

    /**
     * View method
     *
     * @param string|null $id Coefficient id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $coefficient = $this->Coefficients->get($id, [
            'contain' => ['Promotions', 'Niveaux', 'Series']
        ]);

        $this->set('coefficient', $coefficient);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $coefficient = $this->Coefficients->newEntity();
        if ($this->request->is('post')) {
            $coefficient = $this->Coefficients->patchEntity($coefficient, $this->request->getData());
            if ($this->Coefficients->save($coefficient)) {
                $this->Flash->success(__('The coefficient has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The coefficient could not be saved. Please, try again.'));
        }
        $promotions = $this->Coefficients->Promotions->find('list', ['limit' => 200]);
        $niveaux = $this->Coefficients->Niveaux->find('list', ['limit' => 200]);
        $series = $this->Coefficients->Series->find('list', ['limit' => 200]);
        $this->set(compact('coefficient', 'promotions', 'niveaux', 'series'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Coefficient id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $coefficient = $this->Coefficients->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $coefficient = $this->Coefficients->patchEntity($coefficient, $this->request->getData());
            if ($this->Coefficients->save($coefficient)) {
                $this->Flash->success(__('The coefficient has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The coefficient could not be saved. Please, try again.'));
        }
        $promotions = $this->Coefficients->Promotions->find('list', ['limit' => 200]);
        $niveaux = $this->Coefficients->Niveaux->find('list', ['limit' => 200]);
        $series = $this->Coefficients->Series->find('list', ['limit' => 200]);
        $this->set(compact('coefficient', 'promotions', 'niveaux', 'series'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Coefficient id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $coefficient = $this->Coefficients->get($id);
        if ($this->Coefficients->delete($coefficient)) {
            $this->Flash->success(__('The coefficient has been deleted.'));
        } else {
            $this->Flash->error(__('The coefficient could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
