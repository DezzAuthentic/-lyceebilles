<?php
namespace App\Controller\Administration;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Event\Event;
/**
 * Professeurs Controller
 *
 * @property \App\Model\Table\ProfesseursTable $Professeurs
 *
 * @method \App\Model\Entity\Professeur[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProfesseursController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('admin');
    }

    public function editer(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $prof = $this->Professeurs->get($temp["id"],['contain'=>['Users']]);
            $temp['user']["profil"]="professeur";
            if(!empty($temp['user']["passwordChange"])) $temp['user']["password"] = $temp['user']["passwordChange"];
            $prof = $this->Professeurs->patchEntity($prof, $temp);
            if (!$this->Professeurs->save($prof)) {
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
                $this->Flash->success(__("Activation de ".$ok." professeur(s). Echecs: ".$nok."."));
            }
            elseif($action == "desactiver"){
                $ok=0;
                $nok=0;
                foreach ($select as $sel){
                    if($this->desactiv($sel))$ok++;
                    else $nok++;
                }
                $this->Flash->success(__("Désactivation de ".$ok." professeur(s). Echecs: ".$nok."."));
            }
            //$this->Flash->error(__(""));
        }
        return $this->redirect(['prefix'=>'administration','controller'=>'Etablissements','action' => 'gestionUtilisateurs']);        
    }


    //action en masse
    public function activ($id){
        $prof = $this->Professeurs->get($id,['contain'=>['Users']]);
        $user = $prof->user;
        $user->etat=1;
        if ($this->Professeurs->Users->save($user)) {
            return true;
        }
        else return false;
    }
    public function desactiv($id){
        $prof = $this->Professeurs->get($id,['contain'=>['Users']]);
        $user = $prof->user;
        $user->etat=0;
        if ($this->Professeurs->Users->save($user)) {
            return true;
        }
        else return false;
    }
}
