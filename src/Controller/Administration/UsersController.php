<?php
namespace App\Controller\Administration;

use App\Controller\AppController;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function changerEtat($id){
        $user = $this->Employes->Users->get($id);
        $user->etat = $user->etat?0:1;
        $this->Users->save($user);
        return $this->redirect(['prefix'=>'administration','controller'=>'Etablissements','action' => 'gestionUtilisateurs ']);
    }

    public function deconnexion()
    {
        return $this->redirect($this->Auth->logout());
    }
}
