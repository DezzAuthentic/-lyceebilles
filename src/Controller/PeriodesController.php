<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Periodes Controller
 *
 * @property \App\Model\Table\PeriodesTable $Periodes
 *
 * @method \App\Model\Entity\Periode[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PeriodesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Annees']
        ];
        $periodes = $this->paginate($this->Periodes);

        $this->set(compact('periodes'));
    }

    /**
     * View method
     *
     * @param string|null $id Periode id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $periode = $this->Periodes->get($id, [
            'contain' => ['Annees', 'PeriodeBulletins']
        ]);

        $this->set('periode', $periode);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $periode = $this->Periodes->newEntity();
        if ($this->request->is('post')) {
            $periode = $this->Periodes->patchEntity($periode, $this->request->getData());
            if ($this->Periodes->save($periode)) {
                $this->Flash->success(__('The periode has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The periode could not be saved. Please, try again.'));
        }
        $annees = $this->Periodes->Annees->find('list', ['limit' => 200]);
        $this->set(compact('periode', 'annees'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Periode id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $periode = $this->Periodes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $periode = $this->Periodes->patchEntity($periode, $this->request->getData());
            if ($this->Periodes->save($periode)) {
                $this->Flash->success(__('The periode has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The periode could not be saved. Please, try again.'));
        }
        $annees = $this->Periodes->Annees->find('list', ['limit' => 200]);
        $this->set(compact('periode', 'annees'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Periode id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $periode = $this->Periodes->get($id);
        if ($this->Periodes->delete($periode)) {
            $this->Flash->success(__('The periode has been deleted.'));
        } else {
            $this->Flash->error(__('The periode could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
