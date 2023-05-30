<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Reductions Controller
 *
 * @property \App\Model\Table\ReductionsTable $Reductions
 *
 * @method \App\Model\Entity\Reduction[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReductionsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Inscriptions']
        ];
        $reductions = $this->paginate($this->Reductions);

        $this->set(compact('reductions'));
    }

    /**
     * View method
     *
     * @param string|null $id Reduction id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $reduction = $this->Reductions->get($id, [
            'contain' => ['Inscriptions']
        ]);

        $this->set('reduction', $reduction);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $reduction = $this->Reductions->newEntity();
        if ($this->request->is('post')) {
            $reduction = $this->Reductions->patchEntity($reduction, $this->request->getData());
            if ($this->Reductions->save($reduction)) {
                $this->Flash->success(__('The reduction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reduction could not be saved. Please, try again.'));
        }
        $inscriptions = $this->Reductions->Inscriptions->find('list', ['limit' => 200]);
        $this->set(compact('reduction', 'inscriptions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Reduction id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $reduction = $this->Reductions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $reduction = $this->Reductions->patchEntity($reduction, $this->request->getData());
            if ($this->Reductions->save($reduction)) {
                $this->Flash->success(__('The reduction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reduction could not be saved. Please, try again.'));
        }
        $inscriptions = $this->Reductions->Inscriptions->find('list', ['limit' => 200]);
        $this->set(compact('reduction', 'inscriptions'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Reduction id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $reduction = $this->Reductions->get($id);
        if ($this->Reductions->delete($reduction)) {
            $this->Flash->success(__('The reduction has been deleted.'));
        } else {
            $this->Flash->error(__('The reduction could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
