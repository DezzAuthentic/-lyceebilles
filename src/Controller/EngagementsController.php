<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Engagements Controller
 *
 *
 * @method \App\Model\Entity\Engagement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EngagementsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $engagements = $this->paginate($this->Engagements);

        $this->set(compact('engagements'));
    }

    /**
     * View method
     *
     * @param string|null $id Engagement id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $engagement = $this->Engagements->get($id, [
            'contain' => []
        ]);

        $this->set('engagement', $engagement);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $engagement = $this->Engagements->newEntity();
        if ($this->request->is('post')) {
            $engagement = $this->Engagements->patchEntity($engagement, $this->request->getData());
            if ($this->Engagements->save($engagement)) {
                $this->Flash->success(__('The engagement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The engagement could not be saved. Please, try again.'));
        }
        $this->set(compact('engagement'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Engagement id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $engagement = $this->Engagements->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $engagement = $this->Engagements->patchEntity($engagement, $this->request->getData());
            if ($this->Engagements->save($engagement)) {
                $this->Flash->success(__('The engagement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The engagement could not be saved. Please, try again.'));
        }
        $this->set(compact('engagement'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Engagement id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $engagement = $this->Engagements->get($id);
        if ($this->Engagements->delete($engagement)) {
            $this->Flash->success(__('The engagement has been deleted.'));
        } else {
            $this->Flash->error(__('The engagement could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
