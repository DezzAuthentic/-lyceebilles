<?php
namespace App\Controller\Academie;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;


class ArchivesController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('academie');
    }

    public function index(){

        $this->loadModel("Annees");
        $this->loadModel("Mois");

        $etab = $this->getEtablissement();
        $list_mois = $this->Mois->find("list");

        $annees = $this->Annees->find('all',[
            "conditions" => ['Annees.id <' => $etab->annee_id,'Annees.etablissement_id' => $etab->id]
        ]);

        $this->set(compact("annees","list_mois"));
        
    }

    public function init($annee_id){

        $session = $this->request->getSession();
        $session->write("annee_id",$annee_id);

        return $this->redirect(["action" => "promotions"]);

    }

    public function loadAnnee(){

        $this->loadModel("Annees");

        $session = $this->request->getSession();
        $annee_id = $session->read("annee_id");

        if($annee_id) return $this->Annees->get($annee_id);
        return false;
        
    }

    public function verifAnnee($annee){
        
        if(!$annee) {
            $this->Flash->error("Veuillez choisir une année!");
            return $this->redirect(['action' => "index"]);
        }

    }

    public function promotions(){

        $this->loadModel("Promotions");

        $annee = $this->loadAnnee();
        $this->verifAnnee($annee);

        $promotions = $this->Promotions->find("all",[
            'contain' => ['Inscriptions','Groupes','Niveaux'], 
            'conditions' => ['Promotions.annee_id'=>$annee->id],
            'order' => ["Niveaux.ordre" => "ASC"]
        ]);

        $this->set(compact('promotions','annee'));    

    }

    public function promotion($id){

        $this->loadModel("Promotions");

        $promotion = $this->Promotions->get($id,[
            'contain' => ['Groupes.Affectations','Inscriptions.Eleves','Annees']
        ]);

        $groupes_list = $this->Promotions->Groupes->find('list',[
            'conditions' => ['Groupes.promotion_id'=> $id]
        ]);

        $this->set(compact('promotion','groupes_list'));

    }

    public function groupe($id){

        $this->loadModel('Groupes');
        $this->loadModel('Matieres');
        $this->loadModel('Professeurs');
        $this->loadModel("Seances");

        $etab = $this->getEtablissement();

        $groupe = $this->Groupes->get($id,[
            "contain" => ['Affectations.Inscriptions.Eleves','Cours.Matieres',"Cours.Professeurs","Cours.Edt","Promotions.Annees"]
        ]);

        $seances = $this->Seances->find('all',[
            'contain' => ['Cours.Matieres','Cours.Professeurs','Cours.Groupes','Presences'],
            'conditions' => ['Groupes.id' => $id]
        ]);

        $matieres_id = Array();
        foreach($groupe->cours as $cour){
            $matieres_id[] = $cour->matiere_id;
        }
        if(sizeof($matieres_id)>0){
            $matieres = $this->Matieres->find('all',[
                'conditions' => ['Matieres.etablissement_id' => $etab->id, 'Matieres.id NOT IN' => $matieres_id]
            ]);
        }else{
            $matieres = $this->Matieres->find('all',[
                'conditions' => ['Matieres.etablissement_id' => $etab->id]
            ]);
        }
        
        $this->set(compact('groupe','matieres','seances'));

    }

    public function edt($groupe_id){

        $this->loadModel("Groupes");
        $this->loadModel("Edt");

        $groupe = $this->Groupes->get($groupe_id,[
            "contain" => ['Cours.Matieres',"Cours.Professeurs"]
        ]);

        $edts = $this->Edt->find('all',[
            "contain" => ['Cours.Matieres','Cours.Professeurs'],
            'conditions' => ['Cours.groupe_id'=>$groupe_id]
        ]);
        
        $this->set(compact('groupe','cours','edts'));

    }

    public function cours($id = null)
    {
        $this->loadModel('Periodes');
        $this->loadModel('Cours');

        $etab = $this->getEtablissement();

        $cours = $this->Cours->get($id, [
            'contain' => ['Matieres','Professeurs','Groupes.Promotions.Annees','Seances.Presences','Devoirs.Periodes']
        ]);
        $periodes = $this->Periodes->find('list',[
            'conditions' => ['Periodes.annee_id' => $etab->annee_id, 'Periodes.statut !='=>'clôturé']
        ]);
        
        $this->set(compact('cours','periodes'));
    }

    public function seance($id = null){

        $this->loadModel('Seances');
        $seance = $this->Seances->get($id, [
            'contain' => ['Cours.Matieres','Cours.Groupes.Promotions.Annees','Cours.Professeurs','Cours.Groupes.Affectations.Inscriptions.Eleves','Exercices','Presences',
                'Cours.Groupes.Affectations.Inscriptions'=>['conditions'=> ['Inscriptions.etat !='=>'suspendu']]]
        ]);

        $this->set('seance', $seance);

    }

    public function devoir($id = null){

        $this->loadModel('Devoirs');
        $devoir = $this->Devoirs->get($id, [
            'contain' => ['Cours.Matieres','Cours.Professeurs','Cours.Groupes.Promotions.Annees','Cours.Groupes.Affectations.Inscriptions.Eleves','Periodes','DevoirNotes',
            'Cours.Groupes.Affectations.Inscriptions'=>['conditions'=> ['Inscriptions.etat !='=>'suspendu']]
            ]
        ]);
        
        $this->set(compact('devoir'));

    }

    public function cahierDeTexte($id = null){

        $this->loadModel('Cours');
        $this->loadModel('Periodes');
        $etab = $this->getEtablissement();

        $cours = $this->Cours->get($id, [
            'contain' => ['Matieres','Professeurs','Groupes.Promotions.Annees','Seances' => [
                'sort' => ['Seances.date' => 'Desc', 'Seances.duree' => 'Desc']
            ]]
        ]);
        
        $this->set(compact('cours'));

    }
}
