<?php
namespace App\Controller\Academie;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Event\Event;

/**
 * Tuteurs Controller
 *
 * @property \App\Model\Table\TuteursTable $Tuteurs
 *
 * @method \App\Model\Entity\Tuteur[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TuteursController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('academie');
    }
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */

    public function fiche($id){
        $tuteur = $this->Tuteurs->get($id,[
            'contain' => ['Users','Eleves.Inscriptions.Affectations.Groupes','Eleves.Inscriptions.Promotions.Annees']
        ]);
        $this->set(compact('tuteur'));
    }

    public function modifier($id){
        $tuteur = $this->Tuteurs->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $temp = $this->request->getData();
            //dd($temp);
            $tuteur = $this->Tuteurs->patchEntity($tuteur, $temp);
            if (!$this->Tuteurs->save($tuteur)) {
                $this->Flash->error(__("La modification n'a pu être effectuée. Merci de réessayer!"));
            }else $this->redirect(['action'=>'fiche',$tuteur->id]);
        }
        $this->set(compact('tuteur'));
    }

    public function editerPhoto(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $id = $temp['id'];
            $image = $temp['image'];
            $extensions = array("jpeg", "jpg", "gif","png");
            $url = $this->definirPj($image,$extensions,'tuteurs',$id);
            if(!$url){  
                $this->Flash->error(__("L'imge n'a pu être modifiée. Merci de réessayer."));
            }else{
                $tuteur = $this->Tuteurs->get($id);
                $tuteur->photo = $url;
                $this->Tuteurs->save($tuteur);
            }
            return $this->redirect($this->referer());
        }
    }
}


