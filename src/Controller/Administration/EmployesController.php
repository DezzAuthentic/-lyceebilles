<?php
namespace App\Controller\Administration;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Event\Event;

class EmployesController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('admin');
    }

    public function editerAdmin(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $admin = $this->Employes->get($temp["id"],['contain'=>['Users']]);
            $admin = $this->Employes->patchEntity($admin, $temp);
            if ($this->Employes->save($admin)) {
                return $this->redirect(['prefix'=>'administration','controller'=>'Etablissements','action' => 'parametrage']);
            }
            $this->Flash->error(__("L'édition n'a pu être enregistrée. Merci de réessayer."));
            dd($admin);
        }
    }

    public function ajouter(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $employe = $this->Employes->newEntity();
            $employe = $this->Employes->patchEntity($employe, $temp);
            if (!$this->Employes->save($employe)) {
                $this->Flash->error(__("L'ajout n'a pu être effectué. Merci de réessayer."));
            }
            //dd($employe);
            return $this->redirect(['prefix'=>'administration','controller'=>'Etablissements','action' => 'gestionUtilisateurs ']);
        }
    }

    public function editer(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $employe = $this->Employes->get($temp["id"],['contain'=>['Users']]);
            if(!empty($temp['user']["passwordChange"])) $temp['user']["password"] = $temp['user']["passwordChange"];
            $employe = $this->Employes->patchEntity($employe, $temp);
            if (!$this->Employes->save($employe)) {
                $this->Flash->error(__("L'édition n'a pu être enregistrée. Merci de réessayer."));
            }
            //dd($employe);
            return $this->redirect(['prefix'=>'administration','controller'=>'Etablissements','action' => 'gestionUtilisateurs ']);
        }
    }

    public function supprimer(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $employe = $this->Employes->get($temp["id"],['contain'=>['Users']]);
            $user = $employe->user;
            //pas de suppression si c'est l'admin de l'établissement
            if($this->getEtablissement()->admin_id == $temp["id"]) {
                $this->Flash->error(__("L'administrateur ne peut être supprimé."));
            return $this->redirect(['prefix'=>'administration','controller'=>'Etablissements','action' => 'gestionUtilisateurs ']);                
            }
            if (!$this->Employes->delete($employe) or !$this->Employes->Users->delete($user)) {
                $this->Flash->error(__("La suppression n'a pu être faite. Merci de réessayer."));
            }
            return $this->redirect(['prefix'=>'administration','controller'=>'Etablissements','action' => 'gestionUtilisateurs ']);
        }
    }

    public function editerImage(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $id = $temp['id'];
            $image = $temp['image'];
            if(!$this->definirImage($image,$id)){  
                $this->Flash->error(__("L'image n'a pu être modifiée. Merci de réessayer."));
            };
            return $this->redirect(['prefix'=>'administration','controller'=>'Etablissements','action' => 'parametrage']);        
        }
    }

    public function definirImage($image,$employe_id){
        $result = false;
        $errors = array();
        $extensions = array("jpeg", "jpg", "gif","png");
        $bytes = 1024;
        $allowedKB = 10000;
        $totalBytes = $allowedKB * $bytes;
        $uploadThisFile = true;
        $file_name = $image['name'];
        $file_tmp = $image['tmp_name'];
        
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        if (!in_array(strtolower($ext), $extensions)) {
            array_push($errors, "Le nom du fichier est invalide " . $file_name);
            $uploadThisFile = false;
        }
    
        if ($image['size'] > $totalBytes) {
            array_push($errors, "la taille du fichier ne doit pas depasser 100KB. Name:- " . $file_name);
            $uploadThisFile = false;
        }
        
        $target_dir = WWW_ROOT.DS."documents".DS."administration".DS."photos".DS;
        if(!file_exists($target_dir)){
            mkdir($target_dir, 0777, true);
        }
        if ($uploadThisFile) {
            $newFileName = $employe_id.'.'.$ext;
            $desti_file = $target_dir . $newFileName;
            $employe = $this->Employes->get($employe_id);
            $desti_url = Router::url('/documents/administration/photos/').$newFileName;
            $employe->photo = $desti_url;
        
            move_uploaded_file($file_tmp, $desti_file); 
            $this->Employes->save($employe);
            $result = true;
        }
        return $result;
    }
      
    public function supprimerImage($nom){
        $path = WWW_ROOT.DS."documents".DS."administration".DS."photos".DS;
        $file = new File($path.$nom);  
        $file->delete();
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
                $this->Flash->success(__("Activation de ".$ok." agents. Echecs: ".$nok."."));
            }
            elseif($action == "desactiver"){
                $ok=0;
                $nok=0;
                foreach ($select as $sel){
                    if($this->desactiv($sel))$ok++;
                    else $nok++;
                }
                $this->Flash->success(__("Désactivation de ".$ok." agents. Echecs: ".$nok."."));
            }
            elseif($action == "supprimer"){
                $ok=0;
                $nok=0;
                foreach ($select as $sel){
                    if($this->suppr($sel))$ok++;
                    else $nok++;
                }
                $this->Flash->success(__("Suppression de ".$ok." agents. Echecs: ".$nok."."));
            }
            //$this->Flash->error(__(""));
        }
        return $this->redirect(['prefix'=>'administration','controller'=>'Etablissements','action' => 'gestionUtilisateurs']);        
    }


    //action en masse
    public function suppr($id){
        $employe = $this->Employes->get($id,['contain'=>['Users']]);
        $user = $employe->user;
        if (!$this->Employes->delete($employe) or !$this->Employes->Users->delete($user)) {
            return false;
        }
        else return true;
    }
    public function activ($id){
        $employe = $this->Employes->get($id,['contain'=>['Users']]);
        $user = $employe->user;
        $user->etat=1;
        if ($this->Employes->Users->save($user)) {
            return true;
        }
        else return false;
    }
    public function desactiv($id){
        $employe = $this->Employes->get($id,['contain'=>['Users']]);
        $user = $employe->user;
        $user->etat=0;
        if ($this->Employes->Users->save($user)) {
            return true;
        }
        else return false;
    }
}