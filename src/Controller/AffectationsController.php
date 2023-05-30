<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Affectations Controller
 *
 * @property \App\Model\Table\AffectationsTable $Affectations
 *
 * @method \App\Model\Entity\Affectation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AffectationsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Eleves', 'Groupes']
        ];
        $affectations = $this->paginate($this->Affectations);

        $this->set(compact('affectations'));
    }

    /**
     * View method
     *
     * @param string|null $id Affectation id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $affectation = $this->Affectations->get($id, [
            'contain' => ['Eleves', 'Groupes', 'PeriodeBulletins']
        ]);

        $this->set('affectation', $affectation);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $affectation = $this->Affectations->newEntity();
        if ($this->request->is('post')) {
            $affectation = $this->Affectations->patchEntity($affectation, $this->request->getData());
            if ($this->Affectations->save($affectation)) {
                $this->Flash->success(__('The affectation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The affectation could not be saved. Please, try again.'));
        }
        $eleves = $this->Affectations->Eleves->find('list', ['limit' => 200]);
        $groupes = $this->Affectations->Groupes->find('list', ['limit' => 200]);
        $this->set(compact('affectation', 'eleves', 'groupes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Affectation id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $affectation = $this->Affectations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $affectation = $this->Affectations->patchEntity($affectation, $this->request->getData());
            if ($this->Affectations->save($affectation)) {
                $this->Flash->success(__('The affectation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The affectation could not be saved. Please, try again.'));
        }
        $eleves = $this->Affectations->Eleves->find('list', ['limit' => 200]);
        $groupes = $this->Affectations->Groupes->find('list', ['limit' => 200]);
        $this->set(compact('affectation', 'eleves', 'groupes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Affectation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $affectation = $this->Affectations->get($id);
        if ($this->Affectations->delete($affectation)) {
            $this->Flash->success(__('The affectation has been deleted.'));
        } else {
            $this->Flash->error(__('The affectation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
