<?php
namespace App\Controller\Finance;

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
        $this->viewBuilder()->setLayout('finance');
    }
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->autoRender = false;
        $rep = false;

        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $tuteur = $this->Tuteurs->newEntity();
            $tuteur = $this->Tuteurs->patchEntity($tuteur, $temp);
            if ($this->Tuteurs->save($tuteur)) {
                $rep = $tuteur; 
            }
        }

        echo json_encode($rep);                    
    }

    public function editer(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $tuteur = $this->Tuteurs->get($temp["id"],['contain'=>['Users']]);
            $temp['user']["profil"]="tuteur";
            if(!empty($temp['user']["passwordChange"])) $temp['user']["password"] = $temp['user']["passwordChange"];
            $tuteur = $this->Tuteurs->patchEntity($tuteur, $temp);
            if (!$this->Tuteurs->save($tuteur)) {
                $this->Flash->error(__("L'édition n'a pu être enregistrée. Merci de réessayer."));
            }
            return $this->redirect(['prefix'=>'administration','controller'=>'Etablissements','action' => 'gestionUtilisateurs ']);
        }
    }

    public function actionEnMasse(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $action = $temp['action'];
            $select = $temp['select'];
            if($action == "activer"){
                $ok=0;
                $nok=0;
                foreach ($select as $sel){
                    if($this->activ($sel))$ok++;
                    else $nok++;
                }
                $this->Flash->success(__("Activation de ".$ok." tuteur(s). Echecs: ".$nok."."));
            }
            elseif($action == "desactiver"){
                $ok=0;
                $nok=0;
                foreach ($select as $sel){
                    if($this->desactiv($sel))$ok++;
                    else $nok++;
                }
                $this->Flash->success(__("Désactivation de ".$ok." tuteur(s). Echecs: ".$nok."."));
            }
            //$this->Flash->error(__(""));
        }
        return $this->redirect(['prefix'=>'administration','controller'=>'Etablissements','action' => 'gestionUtilisateurs']);        
    }


    //action en masse
    public function activ($id){
        $tuteur = $this->Tuteurs->get($id,['contain'=>['Users']]);
        $user = $tuteur->user;
        $user->etat=1;
        if ($this->Tuteurs->Users->save($user)) {
            return true;
        }
        else return false;
    }
    public function desactiv($id){
        $tuteur = $this->Tuteurs->get($id,['contain'=>['Users']]);
        $user = $tuteur->user;
        $user->etat=0;
        if ($this->Tuteurs->Users->save($user)) {
            return true;
        }
        else return false;
    }

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
