<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Matieres Controller
 *
 * @property \App\Model\Table\MatieresTable $Matieres
 *
 * @method \App\Model\Entity\Matiere[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MatieresController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $matieres = $this->paginate($this->Matieres);

        $this->set(compact('matieres'));
    }

    /**
     * View method
     *
     * @param string|null $id Matiere id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $matiere = $this->Matieres->get($id, [
            'contain' => ['Cours', 'Enseignees', 'Tests']
        ]);

        $this->set('matiere', $matiere);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $matiere = $this->Matieres->newEntity();
        if ($this->request->is('post')) {
            $matiere = $this->Matieres->patchEntity($matiere, $this->request->getData());
            if ($this->Matieres->save($matiere)) {
                $this->Flash->success(__('The matiere has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The matiere could not be saved. Please, try again.'));
        }
        $this->set(compact('matiere'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Matiere id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $matiere = $this->Matieres->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $matiere = $this->Matieres->patchEntity($matiere, $this->request->getData());
            if ($this->Matieres->save($matiere)) {
                $this->Flash->success(__('The matiere has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The matiere could not be saved. Please, try again.'));
        }
        $this->set(compact('matiere'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Matiere id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $matiere = $this->Matieres->get($id);
        if ($this->Matieres->delete($matiere)) {
            $this->Flash->success(__('The matiere has been deleted.'));
        } else {
            $this->Flash->error(__('The matiere could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
