<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Annees Controller
 *
 * @property \App\Model\Table\AnneesTable $Annees
 *
 * @method \App\Model\Entity\Annee[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AnneesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $annees = $this->paginate($this->Annees);

        $this->set(compact('annees'));
    }

    /**
     * View method
     *
     * @param string|null $id Annee id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $annee = $this->Annees->get($id, [
            'contain' => ['Periodes', 'Promotions']
        ]);

        $this->set('annee', $annee);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $annee = $this->Annees->newEntity();
        if ($this->request->is('post')) {
            $annee = $this->Annees->patchEntity($annee, $this->request->getData());
            if ($this->Annees->save($annee)) {
                $this->Flash->success(__('The annee has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The annee could not be saved. Please, try again.'));
        }
        $this->set(compact('annee'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Annee id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $annee = $this->Annees->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $annee = $this->Annees->patchEntity($annee, $this->request->getData());
            if ($this->Annees->save($annee)) {
                $this->Flash->success(__('The annee has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The annee could not be saved. Please, try again.'));
        }
        $this->set(compact('annee'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Annee id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $annee = $this->Annees->get($id);
        if ($this->Annees->delete($annee)) {
            $this->Flash->success(__('The annee has been deleted.'));
        } else {
            $this->Flash->error(__('The annee could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
