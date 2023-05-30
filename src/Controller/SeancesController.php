<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Seances Controller
 *
 * @property \App\Model\Table\SeancesTable $Seances
 *
 * @method \App\Model\Entity\Seance[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SeancesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Cours', 'Salles']
        ];
        $seances = $this->paginate($this->Seances);

        $this->set(compact('seances'));
    }

    /**
     * View method
     *
     * @param string|null $id Seance id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $seance = $this->Seances->get($id, [
            'contain' => ['Cours', 'Salles', 'Exercices', 'Presences']
        ]);

        $this->set('seance', $seance);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $seance = $this->Seances->newEntity();
        if ($this->request->is('post')) {
            $seance = $this->Seances->patchEntity($seance, $this->request->getData());
            if ($this->Seances->save($seance)) {
                $this->Flash->success(__('The seance has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seance could not be saved. Please, try again.'));
        }
        $cours = $this->Seances->Cours->find('list', ['limit' => 200]);
        $salles = $this->Seances->Salles->find('list', ['limit' => 200]);
        $this->set(compact('seance', 'cours', 'salles'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Seance id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $seance = $this->Seances->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $seance = $this->Seances->patchEntity($seance, $this->request->getData());
            if ($this->Seances->save($seance)) {
                $this->Flash->success(__('The seance has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seance could not be saved. Please, try again.'));
        }
        $cours = $this->Seances->Cours->find('list', ['limit' => 200]);
        $salles = $this->Seances->Salles->find('list', ['limit' => 200]);
        $this->set(compact('seance', 'cours', 'salles'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Seance id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $seance = $this->Seances->get($id);
        if ($this->Seances->delete($seance)) {
            $this->Flash->success(__('The seance has been deleted.'));
        } else {
            $this->Flash->error(__('The seance could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
