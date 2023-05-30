<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Mois Controller
 *
 * @property \App\Model\Table\MoisTable $Mois
 *
 * @method \App\Model\Entity\Mois[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MoisController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $mois = $this->paginate($this->Mois);

        $this->set(compact('mois'));
    }

    /**
     * View method
     *
     * @param string|null $id Mois id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $mois = $this->Mois->get($id, [
            'contain' => ['Engagements', 'Factures']
        ]);

        $this->set('mois', $mois);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $mois = $this->Mois->newEntity();
        if ($this->request->is('post')) {
            $mois = $this->Mois->patchEntity($mois, $this->request->getData());
            if ($this->Mois->save($mois)) {
                $this->Flash->success(__('The mois has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The mois could not be saved. Please, try again.'));
        }
        $this->set(compact('mois'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Mois id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $mois = $this->Mois->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $mois = $this->Mois->patchEntity($mois, $this->request->getData());
            if ($this->Mois->save($mois)) {
                $this->Flash->success(__('The mois has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The mois could not be saved. Please, try again.'));
        }
        $this->set(compact('mois'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Mois id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $mois = $this->Mois->get($id);
        if ($this->Mois->delete($mois)) {
            $this->Flash->success(__('The mois has been deleted.'));
        } else {
            $this->Flash->error(__('The mois could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
