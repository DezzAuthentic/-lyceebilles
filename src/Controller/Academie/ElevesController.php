<?php
namespace App\Controller\Academie;

use App\Controller\AppController;
use Cake\Event\Event;
use cake\Routing\Router;
/**
 * Eleves Controller
 *
 * @property \App\Model\Table\ElevesTable $Eleves
 *
 * @method \App\Model\Entity\Elef[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ElevesController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('academie');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    
    public function fiche($id){
        $eleve = $this->Eleves->get($id,[
            'contain' => ['Tuteurs.Users','Inscriptions.Affectations.Groupes','Inscriptions.Promotions.Annees']
        ]);
        $this->set(compact('eleve'));
    }

    public function modifier($id){
        $eleve = $this->Eleves->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $temp = $this->request->getData();
            //dd($temp);
            $eleve = $this->Eleves->patchEntity($eleve, $temp);
            if (!$this->Eleves->save($eleve)) {
                $this->Flash->error(__("La modification n'a pu être effectuée. Merci de réessayer!"));
            }else $this->redirect(['action'=>'fiche',$eleve->id]);
        }
        $this->set(compact('eleve'));
    }

    public function editerPhoto(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $id = $temp['id'];
            $image = $temp['image'];
            $extensions = array("jpeg", "jpg", "gif","png");
            $url = $this->definirPj($image,$extensions,'eleves',$id);
            if(!$url){  
                $this->Flash->error(__("L'imge n'a pu être modifiée. Merci de réessayer."));
            }else{
                $eleve = $this->Eleves->get($id);
                $eleve->photo = $url;
                $this->Eleves->save($eleve);
            }
            return $this->redirect($this->referer());
        }
    }
}
