<?php
namespace App\Controller\Professorat;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Cours Controller
 *
 * @property \App\Model\Table\CoursTable $Cours
 *
 * @method \App\Model\Entity\Cour[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CoursController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('prof');
    }

    public function index(){
        $etab = $this->getEtablissement();

        $user_id = $this->logUser();
        $this->loadModel("Professeurs");
        $prof = $this->Professeurs->find('all',[
            'conditions' => ['Professeurs.user_id'=>$user_id]
        ])->first();

        $cours = $this->Cours->find('all',[
            'contain' => ['Matieres','Professeurs','Groupes.Promotions','Seances.Presences','Edt'],
            'conditions' => ['Promotions.annee_id' => $etab->annee_id, 'Professeurs.id'=>$prof->id]
        ]);
        $this->set(compact('cours'));
    }
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */

    /**
     * Edit method
     *
     * @param string|null $id Cour id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */ 
    public function fiche($id = null)
    {
        $this->loadModel('Periodes');
        $etab = $this->getEtablissement();

        $cours = $this->Cours->get($id, [
            'contain' => ['Matieres','Professeurs','Groupes','Seances.Presences','Devoirs.Periodes']
        ]);
        $periodes = $this->Periodes->find('list',[
            'conditions' => ['Periodes.annee_id' => $etab->annee_id, 'Periodes.statut !='=>'clôturé']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cours = $this->Cours->patchEntity($cours, $this->request->getData());
            if ($this->Cours->save($cours)) {
                $this->Flash->success(__('Présentation mise à jour avec succès.'));
            } else $this->Flash->error(__("La présentation n'a pu être mise à jour. Merci de réessayer."));
        }
        $this->set(compact('cours','periodes'));
    }

    public function cahierDeTexte($id = null)
    {
        $this->loadModel('Periodes');
        $etab = $this->getEtablissement();

        $cours = $this->Cours->get($id, [
            'contain' => ['Matieres','Professeurs','Groupes','Seances' => [
                'sort' => ['Seances.date' => 'Desc', 'Seances.duree' => 'Desc']
            ]]
        ]);
        
        $this->set(compact('cours'));
    }

    public function editerPj(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $id = $temp['id'];
            $pj = $temp['pj'];
            $extensions = array("pdf", "doc", "docx","ppt","pptx");
            $url = $this->definirPj($pj,$extensions,'cours',$id);
            if(!$url){  
                $this->Flash->error(__("Le document n'a pu être modifiée. Merci de réessayer."));
            }else{
                $cours = $this->Cours->get($id);
                $cours->pj = $url;
                $this->Cours->save($cours);
            }
            return $this->redirect($this->referer());
        }
    }
    
}
