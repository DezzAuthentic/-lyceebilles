<?php
namespace App\Controller\Administration;

use App\Controller\AppController;
use Cake\Event\Event;
use cake\Routing\Router;
use Cake\I18n\Time;
//use \Mailjet\Resources;

class EtablissementsController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('admin');
    }

    public function parametrage(){

    }

    public function editer(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $etab = $this->Etablissements->get($temp["id"]);
            $etab = $this->Etablissements->patchEntity($etab, $temp);
            if ($this->Etablissements->save($etab)) {
                return $this->redirect(['prefix'=>'administration','controller'=>'Etablissements','action' => 'parametrage',$etab->id]);
            }
            $this->Flash->error(__("L'édition n'a pu être enregistrée. Merci de réessayer."));
        }
    }

    public function editerImage(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $id = $temp['id'];
            $image = $temp['image'];
            if(!$this->definirImage($image,$id)){
                $this->Flash->error(__("L'imge n'a pu être modifiée. Merci de réessayer."));
            };
            return $this->redirect(['prefix'=>'administration','controller'=>'Etablissements','action' => 'parametrage']);

        }
    }

    public function definirImage($image,$etablissement_id){
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

        $target_dir = WWW_ROOT.DS."documents".DS."etablissements".DS."logos".DS;
        if(!file_exists($target_dir)){
            mkdir($target_dir, 0777, true);
        }
        if ($uploadThisFile) {
            $newFileName = $etablissement_id.'.'.$ext;
            $desti_file = $target_dir . $newFileName;
            $etab = $this->Etablissements->get($etablissement_id);
            $desti_url = Router::url('/documents/etablissements/logos/').$newFileName;
            $etab->logo = $desti_url;

            move_uploaded_file($file_tmp, $desti_file);
            $this->Etablissements->save($etab);
            $result = true;
        }
        return $result;
    }

    public function supprimerImage($nom){
        $path = WWW_ROOT.DS."documents".DS."administration".DS."photos".DS;
        $file = new File($path.$nom);
        $file->delete();
    }

    public function activerAnnee($etab_id, $annee_id){
        $etab = $this->Etablissements->get($etab_id);
        $etab->annee_id = $annee_id;
        $this->Etablissements->save($etab);
        return $this->redirect(['controller'=>'Annees','action' => 'configuration']);
    }

    public function gestionUtilisateurs(){
        $etab = $this->getEtablissement();

        $personnel = $this->Etablissements->Employes->find('all',[
            'contain' => ['Users'],
            'conditions' => ['Employes.etablissement_id'=>$etab->id]
        ]);

        $professeurs = $this->Etablissements->Professeurs->find('all',[
            'contain' => ['Users'],
            'conditions' => ['Professeurs.etablissement_id'=>$etab->id]
        ]);

        $eleves = $this->Etablissements->Eleves->find('all',[
            'contain' => ['Users'],
            'conditions' => ['Eleves.etablissement_id'=>$etab->id,'Eleves.etat !=' => 0]
        ]);

        $tuteurs = $this->Etablissements->Tuteurs->find('all',[
            'contain' => ['Users'],
            'conditions' => ['Tuteurs.etablissement_id'=>$etab->id, 'Tuteurs.etat !=' => 0]
        ]);

        $t_secondaires = $this->Etablissements->Tuteurs->TuteurSecondaires->find('all',[
            'contain' => ['Users','Tuteurs'],
            'conditions' => ['Tuteurs.etablissement_id'=>$etab->id]
        ]);

        $this->set(compact('personnel','professeurs','eleves','tuteurs','t_secondaires'));
    }

    public function parametrageGeneral(){
        $etab = $this->getEtablissement();
        $niveaux = $this->Etablissements->Niveaux->find("all",[
            'conditions' => [],
            'order' => ['Niveaux.ordre Asc']
        ]);
        $series = $this->Etablissements->Series->find("all",[
            'conditions' => []
        ]);
        $salles = $this->Etablissements->Salles->find("all",[
            'conditions' => ['Salles.etablissement_id'=>$etab->id]
        ]);
        $matieres = $this->Etablissements->Matieres->find("all",[
            'conditions' => ['Matieres.etablissement_id'=>$etab->id]
        ]);
        $this->loadModel("Promotions");
        $list_niveaux = $this->Etablissements->Niveaux->find("list",[
            'conditions' => []
        ]);
        $list_series = $this->Etablissements->Series->find("list",[
            'conditions' => []
        ]);

        $promotions = $this->Promotions->find("all",[
            'contain' => ['Niveaux'],
            'conditions' => ['Promotions.annee_id'=>$etab->annee_id],
            'order' =>['Niveaux.ordre'=>'ASC']
        ]);

        $this->set(compact("niveaux","series","salles","matieres","list_niveaux","list_series","promotions"));
    }

    /**
     * Paramétrage du module financier
     * Définir les types de frais. Ex: Scolarité, internat, transport...
     */
    public function parametrageFinancier(){

        $etab = $this->getEtablissement();

        $types = $this->Etablissements->Types->find("all",[
            'conditions' => ['Types.etablissement_id'=>$etab->id]
        ]);
        $mois = $this->Etablissements->Mois->find("all",[
            'conditions' => ['Mois.etablissement_id'=>$etab->id]
        ]);

        $this->loadModel("Frais");

        $frais = $this->Frais->find("all",[
            'contain' => ["Niveaux",'Series',"Types"],
            'conditions' => ['Types.etablissement_id'=>$etab->id],
            'order' => ["Niveaux.ordre ASC", "Series.nom ASC","Types.nom ASC"]
        ]);

        $niveaux = $this->Frais->Niveaux->find("list",[
            "conditions" => []
        ]);
        $series = $this->Frais->Series->find("list",[
            "conditions" => []
        ]);
        $liste_types = $this->Etablissements->Types->find("list",[
            'conditions' => ['Types.etablissement_id'=>$etab->id]
        ]);

        $this->set(compact("types","mois","frais",'niveaux','series','liste_types'));
    }

    public function genererMatricule($eleve_id){
        $this->loadModel("Eleves");
        $eleve = $this->Eleves->get($eleve_id);
        $eleve->matricule = 'B'.Date('y').'-T'.$eleve->tuteur_id.'-'.$eleve->id;
        $this->Eleves->save($eleve);
    }

    public function genererAllMatricules($etab_id){
        $etab = $this->getEtablissement();
        $this->loadModel("Eleves");
        $eleves = $this->Eleves->find("all",[
            'conditions' => ['Eleves.etablissement_id'=>$etab->id]
        ]);

        foreach($eleves as $eleve){
            if($eleve->matricule) continue;
            $this->genererMatricule($eleve->id);
        }
        $this->redirect($this->referer());
    }

    /*public function testEmail(){
        $apikey = '3b795f369165a7a108363397cb73a61c';
        $apisecret = '00abdc94e2f7abdee5ff8ef6f65abcf8';

        $mj = new \Mailjet\Client($apikey, $apisecret);


        $body = [
            'FromEmail' => "contact@afridev-group.com",
            'FromName' => "Mac",
            'Subject' => "Your email flight plan!",
            'Text-part' => "Dear tester, welcome to Mailjet! May the delivery force be with you!",
            //'Html-part' => "<h3>Dear tester, welcome to Mailjet!</h3><br />May the delivery force be with you!",
            'Recipients' => [
                [
                    'Email' => "macfallm@gmail.com"
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() && var_dump($response->getData());
    } */
}
