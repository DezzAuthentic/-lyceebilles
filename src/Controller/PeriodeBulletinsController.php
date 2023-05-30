<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PeriodeBulletins Controller
 *
 * @property \App\Model\Table\PeriodeBulletinsTable $PeriodeBulletins
 *
 * @method \App\Model\Entity\PeriodeBulletin[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PeriodeBulletinsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Periodes', 'Affectations']
        ];
        $periodeBulletins = $this->paginate($this->PeriodeBulletins);

        $this->set(compact('periodeBulletins'));
    }

    /**
     * View method
     *
     * @param string|null $id Periode Bulletin id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $periodeBulletin = $this->PeriodeBulletins->get($id, [
            'contain' => ['Periodes', 'Affectations', 'PeriodeBulletinLignes']
        ]);

        $this->set('periodeBulletin', $periodeBulletin);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $periodeBulletin = $this->PeriodeBulletins->newEntity();
        if ($this->request->is('post')) {
            $periodeBulletin = $this->PeriodeBulletins->patchEntity($periodeBulletin, $this->request->getData());
            if ($this->PeriodeBulletins->save($periodeBulletin)) {
                $this->Flash->success(__('The periode bulletin has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The periode bulletin could not be saved. Please, try again.'));
        }
        $periodes = $this->PeriodeBulletins->Periodes->find('list', ['limit' => 200]);
        $affectations = $this->PeriodeBulletins->Affectations->find('list', ['limit' => 200]);
        $this->set(compact('periodeBulletin', 'periodes', 'affectations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Periode Bulletin id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $periodeBulletin = $this->PeriodeBulletins->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $periodeBulletin = $this->PeriodeBulletins->patchEntity($periodeBulletin, $this->request->getData());
            if ($this->PeriodeBulletins->save($periodeBulletin)) {
                $this->Flash->success(__('The periode bulletin has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The periode bulletin could not be saved. Please, try again.'));
        }
        $periodes = $this->PeriodeBulletins->Periodes->find('list', ['limit' => 200]);
        $affectations = $this->PeriodeBulletins->Affectations->find('list', ['limit' => 200]);
        $this->set(compact('periodeBulletin', 'periodes', 'affectations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Periode Bulletin id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $periodeBulletin = $this->PeriodeBulletins->get($id);
        if ($this->PeriodeBulletins->delete($periodeBulletin)) {
            $this->Flash->success(__('The periode bulletin has been deleted.'));
        } else {
            $this->Flash->error(__('The periode bulletin could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
