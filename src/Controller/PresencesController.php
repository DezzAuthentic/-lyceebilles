<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Presences Controller
 *
 * @property \App\Model\Table\PresencesTable $Presences
 *
 * @method \App\Model\Entity\Presence[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PresencesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Seances', 'Eleves']
        ];
        $presences = $this->paginate($this->Presences);

        $this->set(compact('presences'));
    }

    /**
     * View method
     *
     * @param string|null $id Presence id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $presence = $this->Presences->get($id, [
            'contain' => ['Seances', 'Eleves']
        ]);

        $this->set('presence', $presence);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $presence = $this->Presences->newEntity();
        if ($this->request->is('post')) {
            $presence = $this->Presences->patchEntity($presence, $this->request->getData());
            if ($this->Presences->save($presence)) {
                $this->Flash->success(__('The presence has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The presence could not be saved. Please, try again.'));
        }
        $seances = $this->Presences->Seances->find('list', ['limit' => 200]);
        $eleves = $this->Presences->Eleves->find('list', ['limit' => 200]);
        $this->set(compact('presence', 'seances', 'eleves'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Presence id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $presence = $this->Presences->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $presence = $this->Presences->patchEntity($presence, $this->request->getData());
            if ($this->Presences->save($presence)) {
                $this->Flash->success(__('The presence has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The presence could not be saved. Please, try again.'));
        }
        $seances = $this->Presences->Seances->find('list', ['limit' => 200]);
        $eleves = $this->Presences->Eleves->find('list', ['limit' => 200]);
        $this->set(compact('presence', 'seances', 'eleves'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Presence id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $presence = $this->Presences->get($id);
        if ($this->Presences->delete($presence)) {
            $this->Flash->success(__('The presence has been deleted.'));
        } else {
            $this->Flash->error(__('The presence could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
