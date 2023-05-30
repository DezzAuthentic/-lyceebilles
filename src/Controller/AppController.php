<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use cake\Routing\Router;
use \Mailjet\Resources;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');

        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ]
                ]
            ],
            'loginAction' => [
                'prefix'=> false,
                'controller' => 'Users',
                'action' => 'connecter'
            ],
            'loginRedirect' => '/',
            'authError' => false,
            'unauthorizedRedirect' => $this->referer(), // If unauthorized, return them to page they were just on
            'authorize'=> 'Controller'
        ]);
        // Allow the display action so our pages controller
        // continues to work.
        $this->Auth->allow(['display','parametres','editerAdmin','resetPassword']);


        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
    }

    /*public function sendEmail($subject,$email,$message_user,$pj_nom = null,$pj_path=null){
        try{
            $email = new Email(['EmailTransport' => 'default']);
            $email
                ->emailFormat('html')
                ->Profile('default')
                ->to($email)
                ->subject($subject);
                //->send($message_user);
            if (!empty($pj_nom) and !empty($pj_path) ) $email->setAttachments([$pj_nom => $pj_path]);
            $email->send('Cher fournisseur,<br>'.$message_user.'<br><br>Cordialement,<br>From Total - E-COMMANDE');
        }catch(\Exception $e){
            dd($e);
        }        
    }*/

    public function sendEmail($subject,$emails,$message_user/*,$pj_nom=null,$pj_path=null*/){
        try{
  
          $apikey = '3b795f369165a7a108363397cb73a61c';
          $apisecret = '8a7718f2aef03b6680bfc51f7b9c95a3';
  
          $mj = new \Mailjet\Client($apikey, $apisecret);
          
          $msg = $message_user."<br><br>Cordialement,<br>Total Sénégal";
  
          $recipients = [];
  
          foreach($emails as $email){
            $recipients[] = ['Email' => $email];
          }
          
          /*$data = file_get_contents($pj_path);
          $base64 = base64_encode($data);*/
  
          $body = [
              'FromEmail' => "contact@afridev-group.com",
              'FromName' => "Lycée d'Excellence BILLES",
              'Subject' => $subject,
              //'Text-part' => "Dear tester, welcome to Mailjet! May the delivery force be with you!",
              'Html-part' => $msg,
              'Recipients' => $recipients
              /*'Attachments' => [
                  [
                      'Content-type' => "application/pdf",
                      'Filename' => $pj_nom,
                      'content' => $base64
                  ]
              ]*/
          ];
          $mj->setTimeout(10);
          $response = $mj->post(Resources::$Email, ['body' => $body]);
          //$response->success() && var_dump($response->getData());

        }catch(\Exception $e){
          dd($e);
        }        
      }

    public function beforeFilter(Event $event){
        /* 
        Variables à charger: etablissement,...
        */
        $etablissement = $this->getEtablissement();
        $admin = $this->getAdmin($etablissement->id);
        $this->loadModel('Mois');
        $this->loadModel('Types');
        if($etablissement->annee){
            $debut = $this->Mois->get($etablissement->annee->debut);
            $fin = $this->Mois->get($etablissement->annee->fin);
        }
        $user = $this->getUser();
        $_types_fac = $this->Types->find('all',[
            'conditions' => ['Types.etablissement_id' => $etablissement->id, "Types.obligatoire" => 0,'Types.recurrence' => 1]
        ]);
        $this->set(compact('etablissement','admin','debut','fin','user','_types_fac'));
    }

    public function getEtablissement(){
        $this->loadModel('Etablissements');
        $etablissement = $this->Etablissements->find('all',[
            'contain' => ['Configurations'],
            'conditions' => ['Etablissements.id'=> 1]
            //'conditions' => ['Users.id'=> $this->Auth->user('id')]
        ])->first();
        if($etablissement->annee_id != null) {
            $annee = $this->Etablissements->Annees->get($etablissement->annee_id);
            $etablissement->annee = $annee;
        }
        return $etablissement;
    }
    public function getAdmin($etablissement_id){
        $this->loadModel('Employes');
        $admin = $this->Employes->find('all',[
            'contain' => ['Users'],
            'conditions' => ['Employes.etablissement_id'=> $etablissement_id,'Users.profil' => 'admin']
        ])->first();
        return $admin;
    }
    public function logUser(){
        $this->loadModel('Users');
        $log_user = $this->Auth->user('id');
        return $log_user;
    }
    public function getUser(){
        $this->loadModel("Users");
        if($this->logUser() == null) return null;
        $user = $this->Users->get($this->logUser(),[
            'contain' => ['Employes','Eleves','Professeurs.Matieres','Tuteurs','TuteurSecondaires.Tuteurs']
        ]);
        return $user;
    }
    // renvoie un tableau de mois (à utiliser pour les factures récurrentes)
    public function getMois(){
        $etablissement = $this->getEtablissement();
        $this->loadModel('Mois');
        $debut = $this->Mois->get($etablissement->annee->debut);
        $fin = $this->Mois->get($etablissement->annee->fin);
        $mois = $this->Mois->find('all',[
            'conditions' => ['Mois.ordre >=' => $debut->ordre,'Mois.ordre <=' => $fin->ordre,'Mois.etablissement_id' => $etablissement->id]
        ]);
        return $mois;
    }

    public function getCorrMois($id){
        $this->loadModel('Mois');
        $etablissement = $this->getEtablissement();

        $correspondance["01"]='Janvier';
        $correspondance["02"]='Février';
        $correspondance["03"]='Mars';
        $correspondance["04"]='Avril';
        $correspondance["05"]='Mai';
        $correspondance["06"]='Juin';
        $correspondance["07"]='Juillet';
        $correspondance["08"]='Août';
        $correspondance["09"]='Septembre';
        $correspondance["10"]='Octobre';
        $correspondance["11"]='Novembre';
        $correspondance["12"]='Décembre';

        $mois = $this->Mois->find('all',[
            'conditions' => ['Mois.etablissement_id' => $etablissement->id, 'Mois.nom' => $correspondance[$id]]
        ])->first();
        return $mois;
    }
    
    public function definirPj($image,$extensions,$dossier,$nom){
        $result = false;
        $errors = array();
        $bytes = 1024;
        $allowedKB = 16000;
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
            array_push($errors, "la taille du fichier ne doit pas depasser 16Mb. Name:- " . $file_name);
            $uploadThisFile = false;
        }
        
        $target_dir = WWW_ROOT.DS."documents".DS.$dossier.DS;
        if(!file_exists($target_dir)){
            mkdir($target_dir, 0777, true);
        }
        if ($uploadThisFile) {
            $newFileName = $nom.'.'.$ext;
            $desti_file = $target_dir . $newFileName;
            $desti_url = Router::url("documents".DS.$dossier.DS).$newFileName;
        
            move_uploaded_file($file_tmp, $desti_file); 
            $result = $desti_url;
        }
        return $result;
    }

    public function genererCode(int $taille) {
        $length = $taille;
        // debug($length);
        $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $taillechar = strlen($char);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $char[rand(0, $taillechar - 1)];
        }
        return $randomString;
    }

    public function isAuthorized($user = null)
    {
        // Any registered user can access public functions
        /*if (empty($this->request->params['prefix'])) {
            return true;
        }*/

        $user = $this->getUser();

        if($user->profil == 'superadmin' || $user->profil == 'afridev') return true;

        if(!isset($this->request->params['prefix'])) return true;

        if($user->profil=='admin' && in_array($this->request->params['prefix'],['boutique','finance','administration','academie','secretariat'])) return true;
        if($user->profil=='boutiquier' && in_array($this->request->params['prefix'],['boutique'])) return true;
        if($user->profil=='comptable' && in_array($this->request->params['prefix'],['finance'])) return true;
        if($user->profil=='surveillant' && in_array($this->request->params['prefix'],['academie'])) return true;
        if($user->profil=='surveillant2' && in_array($this->request->params['prefix'],['academie'])) return true;
        if($user->profil=='secretaire' && in_array($this->request->params['prefix'],['secretariat'])) return true;
        if($user->profil=='infirmier' && in_array($this->request->params['prefix'],['secretariat'])) return true;
        if($user->profil=='professeur' && in_array($this->request->params['prefix'],['professorat'])) return true;
        if($user->profil=='tuteur' && in_array($this->request->params['prefix'],['suivi'])) return true;
        if($user->profil=='eleve' && in_array($this->request->params['prefix'],['suivi'])) return true;

        return false;
    }
}
