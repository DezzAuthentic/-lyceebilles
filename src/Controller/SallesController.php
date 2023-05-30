<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Salles Controller
 *
 * @property \App\Model\Table\SallesTable $Salles
 *
 * @method \App\Model\Entity\Salle[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SallesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $salles = $this->paginate($this->Salles);

        $this->set(compact('salles'));
    }

    /**
     * View method
     *
     * @param string|null $id Salle id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $salle = $this->Salles->get($id, [
            'contain' => ['Edt', 'Groupes', 'Seances']
        ]);

        $this->set('salle', $salle);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $salle = $this->Salles->newEntity();
        if ($this->request->is('post')) {
            $salle = $this->Salles->patchEntity($salle, $this->request->getData());
            if ($this->Salles->save($salle)) {
                $this->Flash->success(__('The salle has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The salle could not be saved. Please, try again.'));
        }
        $this->set(compact('salle'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Salle id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $salle = $this->Salles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $salle = $this->Salles->patchEntity($salle, $this->request->getData());
            if ($this->Salles->save($salle)) {
                $this->Flash->success(__('The salle has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The salle could not be saved. Please, try again.'));
        }
        $this->set(compact('salle'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Salle id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $salle = $this->Salles->get($id);
        if ($this->Salles->delete($salle)) {
            $this->Flash->success(__('The salle has been deleted.'));
        } else {
            $this->Flash->error(__('The salle could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
