<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AnneeBulletins Controller
 *
 * @property \App\Model\Table\AnneeBulletinsTable $AnneeBulletins
 *
 * @method \App\Model\Entity\AnneeBulletin[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AnneeBulletinsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Affectations']
        ];
        $anneeBulletins = $this->paginate($this->AnneeBulletins);

        $this->set(compact('anneeBulletins'));
    }

    /**
     * View method
     *
     * @param string|null $id Annee Bulletin id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $anneeBulletin = $this->AnneeBulletins->get($id, [
            'contain' => ['Affectations']
        ]);

        $this->set('anneeBulletin', $anneeBulletin);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $anneeBulletin = $this->AnneeBulletins->newEntity();
        if ($this->request->is('post')) {
            $anneeBulletin = $this->AnneeBulletins->patchEntity($anneeBulletin, $this->request->getData());
            if ($this->AnneeBulletins->save($anneeBulletin)) {
                $this->Flash->success(__('The annee bulletin has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The annee bulletin could not be saved. Please, try again.'));
        }
        $affectations = $this->AnneeBulletins->Affectations->find('list', ['limit' => 200]);
        $this->set(compact('anneeBulletin', 'affectations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Annee Bulletin id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $anneeBulletin = $this->AnneeBulletins->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $anneeBulletin = $this->AnneeBulletins->patchEntity($anneeBulletin, $this->request->getData());
            if ($this->AnneeBulletins->save($anneeBulletin)) {
                $this->Flash->success(__('The annee bulletin has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The annee bulletin could not be saved. Please, try again.'));
        }
        $affectations = $this->AnneeBulletins->Affectations->find('list', ['limit' => 200]);
        $this->set(compact('anneeBulletin', 'affectations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Annee Bulletin id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $anneeBulletin = $this->AnneeBulletins->get($id);
        if ($this->AnneeBulletins->delete($anneeBulletin)) {
            $this->Flash->success(__('The annee bulletin has been deleted.'));
        } else {
            $this->Flash->error(__('The annee bulletin could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
