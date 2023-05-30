<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Ouvrages Controller
 *
 * @property \App\Model\Table\OuvragesTable $Ouvrages
 *
 * @method \App\Model\Entity\Ouvrage[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OuvragesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['OuvrageCategories']
        ];
        $ouvrages = $this->paginate($this->Ouvrages);

        $this->set(compact('ouvrages'));
    }

    /**
     * View method
     *
     * @param string|null $id Ouvrage id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ouvrage = $this->Ouvrages->get($id, [
            'contain' => ['OuvrageCategories', 'Emprunts']
        ]);

        $this->set('ouvrage', $ouvrage);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ouvrage = $this->Ouvrages->newEntity();
        if ($this->request->is('post')) {
            $ouvrage = $this->Ouvrages->patchEntity($ouvrage, $this->request->getData());
            if ($this->Ouvrages->save($ouvrage)) {
                $this->Flash->success(__('The ouvrage has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ouvrage could not be saved. Please, try again.'));
        }
        $ouvrageCategories = $this->Ouvrages->OuvrageCategories->find('list', ['limit' => 200]);
        $this->set(compact('ouvrage', 'ouvrageCategories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Ouvrage id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ouvrage = $this->Ouvrages->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ouvrage = $this->Ouvrages->patchEntity($ouvrage, $this->request->getData());
            if ($this->Ouvrages->save($ouvrage)) {
                $this->Flash->success(__('The ouvrage has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ouvrage could not be saved. Please, try again.'));
        }
        $ouvrageCategories = $this->Ouvrages->OuvrageCategories->find('list', ['limit' => 200]);
        $this->set(compact('ouvrage', 'ouvrageCategories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Ouvrage id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ouvrage = $this->Ouvrages->get($id);
        if ($this->Ouvrages->delete($ouvrage)) {
            $this->Flash->success(__('The ouvrage has been deleted.'));
        } else {
            $this->Flash->error(__('The ouvrage could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
