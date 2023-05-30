<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * DevoirNotes Controller
 *
 * @property \App\Model\Table\DevoirNotesTable $DevoirNotes
 *
 * @method \App\Model\Entity\DevoirNote[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DevoirNotesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Devoirs', 'Eleves']
        ];
        $devoirNotes = $this->paginate($this->DevoirNotes);

        $this->set(compact('devoirNotes'));
    }

    /**
     * View method
     *
     * @param string|null $id Devoir Note id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $devoirNote = $this->DevoirNotes->get($id, [
            'contain' => ['Devoirs', 'Eleves']
        ]);

        $this->set('devoirNote', $devoirNote);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $devoirNote = $this->DevoirNotes->newEntity();
        if ($this->request->is('post')) {
            $devoirNote = $this->DevoirNotes->patchEntity($devoirNote, $this->request->getData());
            if ($this->DevoirNotes->save($devoirNote)) {
                $this->Flash->success(__('The devoir note has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The devoir note could not be saved. Please, try again.'));
        }
        $devoirs = $this->DevoirNotes->Devoirs->find('list', ['limit' => 200]);
        $eleves = $this->DevoirNotes->Eleves->find('list', ['limit' => 200]);
        $this->set(compact('devoirNote', 'devoirs', 'eleves'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Devoir Note id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $devoirNote = $this->DevoirNotes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $devoirNote = $this->DevoirNotes->patchEntity($devoirNote, $this->request->getData());
            if ($this->DevoirNotes->save($devoirNote)) {
                $this->Flash->success(__('The devoir note has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The devoir note could not be saved. Please, try again.'));
        }
        $devoirs = $this->DevoirNotes->Devoirs->find('list', ['limit' => 200]);
        $eleves = $this->DevoirNotes->Eleves->find('list', ['limit' => 200]);
        $this->set(compact('devoirNote', 'devoirs', 'eleves'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Devoir Note id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $devoirNote = $this->DevoirNotes->get($id);
        if ($this->DevoirNotes->delete($devoirNote)) {
            $this->Flash->success(__('The devoir note has been deleted.'));
        } else {
            $this->Flash->error(__('The devoir note could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
