<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * OuvrageCategories Controller
 *
 * @property \App\Model\Table\OuvrageCategoriesTable $OuvrageCategories
 *
 * @method \App\Model\Entity\OuvrageCategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OuvrageCategoriesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $ouvrageCategories = $this->paginate($this->OuvrageCategories);

        $this->set(compact('ouvrageCategories'));
    }

    /**
     * View method
     *
     * @param string|null $id Ouvrage Category id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ouvrageCategory = $this->OuvrageCategories->get($id, [
            'contain' => []
        ]);

        $this->set('ouvrageCategory', $ouvrageCategory);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ouvrageCategory = $this->OuvrageCategories->newEntity();
        if ($this->request->is('post')) {
            $ouvrageCategory = $this->OuvrageCategories->patchEntity($ouvrageCategory, $this->request->getData());
            if ($this->OuvrageCategories->save($ouvrageCategory)) {
                $this->Flash->success(__('The ouvrage category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ouvrage category could not be saved. Please, try again.'));
        }
        $this->set(compact('ouvrageCategory'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Ouvrage Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ouvrageCategory = $this->OuvrageCategories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ouvrageCategory = $this->OuvrageCategories->patchEntity($ouvrageCategory, $this->request->getData());
            if ($this->OuvrageCategories->save($ouvrageCategory)) {
                $this->Flash->success(__('The ouvrage category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ouvrage category could not be saved. Please, try again.'));
        }
        $this->set(compact('ouvrageCategory'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Ouvrage Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ouvrageCategory = $this->OuvrageCategories->get($id);
        if ($this->OuvrageCategories->delete($ouvrageCategory)) {
            $this->Flash->success(__('The ouvrage category has been deleted.'));
        } else {
            $this->Flash->error(__('The ouvrage category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
