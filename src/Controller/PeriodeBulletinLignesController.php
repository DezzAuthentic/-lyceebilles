<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PeriodeBulletinLignes Controller
 *
 * @property \App\Model\Table\PeriodeBulletinLignesTable $PeriodeBulletinLignes
 *
 * @method \App\Model\Entity\PeriodeBulletinLigne[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PeriodeBulletinLignesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['PeriodeBulletins', 'Cours']
        ];
        $periodeBulletinLignes = $this->paginate($this->PeriodeBulletinLignes);

        $this->set(compact('periodeBulletinLignes'));
    }

    /**
     * View method
     *
     * @param string|null $id Periode Bulletin Ligne id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $periodeBulletinLigne = $this->PeriodeBulletinLignes->get($id, [
            'contain' => ['PeriodeBulletins', 'Cours']
        ]);

        $this->set('periodeBulletinLigne', $periodeBulletinLigne);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $periodeBulletinLigne = $this->PeriodeBulletinLignes->newEntity();
        if ($this->request->is('post')) {
            $periodeBulletinLigne = $this->PeriodeBulletinLignes->patchEntity($periodeBulletinLigne, $this->request->getData());
            if ($this->PeriodeBulletinLignes->save($periodeBulletinLigne)) {
                $this->Flash->success(__('The periode bulletin ligne has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The periode bulletin ligne could not be saved. Please, try again.'));
        }
        $periodeBulletins = $this->PeriodeBulletinLignes->PeriodeBulletins->find('list', ['limit' => 200]);
        $cours = $this->PeriodeBulletinLignes->Cours->find('list', ['limit' => 200]);
        $this->set(compact('periodeBulletinLigne', 'periodeBulletins', 'cours'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Periode Bulletin Ligne id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $periodeBulletinLigne = $this->PeriodeBulletinLignes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $periodeBulletinLigne = $this->PeriodeBulletinLignes->patchEntity($periodeBulletinLigne, $this->request->getData());
            if ($this->PeriodeBulletinLignes->save($periodeBulletinLigne)) {
                $this->Flash->success(__('The periode bulletin ligne has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The periode bulletin ligne could not be saved. Please, try again.'));
        }
        $periodeBulletins = $this->PeriodeBulletinLignes->PeriodeBulletins->find('list', ['limit' => 200]);
        $cours = $this->PeriodeBulletinLignes->Cours->find('list', ['limit' => 200]);
        $this->set(compact('periodeBulletinLigne', 'periodeBulletins', 'cours'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Periode Bulletin Ligne id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $periodeBulletinLigne = $this->PeriodeBulletinLignes->get($id);
        if ($this->PeriodeBulletinLignes->delete($periodeBulletinLigne)) {
            $this->Flash->success(__('The periode bulletin ligne has been deleted.'));
        } else {
            $this->Flash->error(__('The periode bulletin ligne could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
