<?php
namespace App\Controller;

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

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Eleves', 'Employes', 'Emprunts', 'InscriptionReglements', 'Professeurs', 'ScolariteReglements', 'Tuteurs']
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function connecter()
    {
        if ($this->request->is('post')) {
		
            $user = $this->Auth->identify();
            if ($user && $user['etat'] == 1) {
                $this->Auth->setUser($user);
                //return $this->redirect(['prefix'=>'administration','controller' => 'Etablissements', 'action' => 'parametrage']);
                //return $this->redirect($this->Auth->redirectUrl());
                return $this->loginRedirect($user['profil']);
            }elseif($user && $user['etat'] == 0){
                $this->Flash->error('Votre compte a été suspendu. Merci de contacter l\'admistrateur');
            }else{

                $this->Flash->error('Votre username ou mot de passe est incorrect.');
            }

        }

        return $this->redirect(['controller' => 'Pages', 'action' => 'display','connexion']);
    }

    public function deconnexion()
    {
        return $this->redirect($this->Auth->logout());
    }

    public function loginRedirect($profil){
        if($profil=='superadmin') return $this->redirect(['prefix'=>'afridev','controller' => 'Etablissements', 'action' => 'parametrage']); 
        elseif($profil=='admin') return $this->redirect(['prefix'=>'administration','controller' => 'Dashboard', 'action' => 'index']); 
        elseif($profil=='boutiquier') return $this->redirect(['prefix'=>'boutique','controller' => 'Dashboard', 'action' => 'index']); 
        elseif($profil=='directeur') return $this->redirect(['prefix'=>'direction','controller' => 'Dashboard', 'action' => 'index']); 
        elseif($profil=='comptable') return $this->redirect(['prefix'=>'finance','controller' => 'Dashboard', 'action' => 'index']); 
        elseif($profil=='surveillant') return $this->redirect(['prefix'=>'academie','controller' => 'Dashboard', 'action' => 'index']); 
        elseif($profil=='surveillant2') return $this->redirect(['prefix'=>'academie','controller' => 'Dashboard', 'action' => 'index']); 
        elseif($profil=='secretaire') return $this->redirect(['prefix'=>'secretariat','controller' => 'Dashboard', 'action' => 'index']); 
        elseif($profil=='infirmier') return $this->redirect(['prefix'=>'secretariat','controller' => 'Dashboard', 'action' => 'index']); 
        elseif($profil=='professeur') return $this->redirect(['prefix'=>'professorat','controller' => 'Dashboard', 'action' => 'index']); 
        elseif($profil=='tuteur') return $this->redirect(['prefix'=>'suivi','controller' => 'Dashboard', 'action' => 'index']); 
        elseif($profil=='eleve') return $this->redirect(['prefix'=>'etudes','controller' => 'Dashboard', 'action' => 'index']); 
        else return $this->redirect(['controller' => 'Pages', 'action' => 'home']); 
    }

    public function resetPassword($email){
        $this->autoRender = false;

        $user = $this->Users->find('all',[
            'conditions' => ['Users.email' => $email]
        ])->first();
        $rep = null;
        if($user) {
            $code = $this->genererCode(4);
            $pwd = 'LEB_'.$code;
            $user->password = $pwd;

            $this->Users->save($user);

            //Envoi de la notification
            $objet = "Réinitialisation du votre mot de passe E-BILLES";
            $msg = "Votre nouveau mot de passe est: ".$pwd;
            $this->sendEmail($objet,[$email],$msg);
            $rep='ok';
        }else $rep='ko';
        echo json_encode($rep);
    }
}
