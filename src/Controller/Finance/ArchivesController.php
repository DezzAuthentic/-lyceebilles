<?php
namespace App\Controller\Finance;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;


class ArchivesController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('finance');
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

        $this->loadModel('Groupes');

        $annee = $this->loadAnnee();
        $this->verifAnnee($annee);

        $groupes = $this->Groupes->find('all',[
            'contain' => ['Promotions.Niveaux','Affectations','Promotions.Inscriptions'],
            'conditions' => ['Promotions.annee_id'=> $annee->id],
            'order' => ['Niveaux.ordre' => 'ASC']
        ]);
        $groupes = $groupes->toArray();
        $effectifs = Array();
        $promo_id = null;
        foreach($groupes as $groupe){
            if($promo_id!=$groupe->promotion->id){
                if(!array_key_exists($groupe->promotion->niveau_id,$effectifs)) $effectifs[$groupe->promotion->niveau_id] = 0;
                $effectifs[$groupe->promotion->niveau_id] += sizeof($groupe->promotion->inscriptions);
                $promo_id = $groupe->promotion->id;
            }
        }
        //dd($effectifs);
        $this->set(compact('groupes','effectifs',"annee"));

    }

    function classe($id){
        
        $this->loadModel("Groupes");

        $groupe = $this->Groupes->get($id,[
            "contain" => ['Affectations.Inscriptions.Eleves',"Promotions.Annees"]
        ]);

        $this->set(compact('groupe'));
    }

    public function parEleveMois($inscription_id){
        
        $etab = $this->getEtablissement();
        $this->loadModel("Mois");
        $this->loadModel("Types");
        $this->loadModel("Engagements");
        $this->loadModel("Factures");

        $mois = $this->Mois->find('all',[
            'contain' => ['Factures.Frais.Types','Factures.Inscriptions' => [
                'conditions' => ['Inscriptions.id' => $inscription_id]
            ]]
        ]);
        $mois_list = $this->Mois->find('list');
        
        //$inscription = $this->Factures->Inscriptions->get($inscription_id,['contain'=>['Promotions.Annees']]);
        $inscription = $this->Factures->Inscriptions->get($inscription_id,[
            'contain' => ['Eleves','Promotions.Annees']
        ]);

        $types = $this->Types->find("all",[
            'contain' => ['Frais.Niveaux','Frais.Series','Frais'=> [
                'conditions'=>["Frais.serie_id IS" =>$inscription->promotion->serie_id,"Frais.niveau_id" => $inscription->promotion->niveau_id]]],
            "conditions" => ['Types.etablissement_id' => $etab->id]
        ]);
        //dd($types->toArray());


        $factures = $this->Factures->find('all',[
            'contain' => ['Frais.Types','Inscriptions'],
            'conditions' => ['Inscriptions.id'=> $inscription_id,'Factures.mois_id IS' => null]
        ])->toArray();
        
        $engagements = $this->Engagements->find("all",[
            "contain" => ['Frais'],
            'conditions' => ['Engagements.inscription_id' => $inscription_id]
        ]);
        
        //Total réglements parrain
        $reglements_parrain = $this->Factures->Reglements->find('all',[
            "contain" => ['Factures.Inscriptions'],
            "conditions" => ['Inscriptions.id'=> $inscription_id,'Reglements.parrainage'=>1]
        ]);

        $total_parrain=0;
        foreach($reglements_parrain as $reglement){
            $total_parrain += $reglement->montant;
        }

        $this->set(compact('mois','mois_list','types','inscription','factures','total_parrain'));
    
    }

    public function details($facture_id=null){

        $this->loadModel("Factures");
        if($facture_id == null) return $this->redirect($this->referer());

        $facture = $this->Factures->get($facture_id,[
            'contain' => ['Reglements.Users.Employes','Mois','Inscriptions.Eleves','Inscriptions.Promotions.Annees','Frais.Types']
        ]);

        $this->set(compact('facture'));
    }

    public function detailsMois($inscription_id=null,$mois_id=null){
        
        $this->loadModel("Inscriptions");
        $this->loadModel("Factures");
        $this->loadModel("Mois");

        $inscription = $this->Inscriptions->get($inscription_id,[
            "contain" => ['Promotions.Annees']
        ]);
        if($mois_id){
            $mois = $this->Mois->get($mois_id,[
                'contain' => ['Factures.Reglements.Users.Employes','Factures.Inscriptions.Eleves','Factures.Inscriptions.Promotions','Factures.Inscriptions' => [
                    'conditions' => ['Inscriptions.id' => $inscription_id]
                ]]
            ]);
        }else{
            $mois = new \stdClass();
            $factures = $this->Factures->find("all", [
                'contain' => ['Reglements.Users.Employes','Inscriptions.Eleves','Inscriptions.Promotions','Inscriptions'],
                'conditions' => ['Factures.inscription_id' => $inscription_id]
            ]);
            $mois->factures = $factures->toArray();
        }

        $reglements = $this->Factures->Reglements->find('all',[
            'contain' => ['Users.Employes',"Factures"],
            'conditions' => ['Factures.inscription_id' => $inscription_id, "Factures.mois_id IS" => $mois_id]
        ]);

        $mois->montant = 0;
        $mois->paye = 0;
        $mois->restant = 0;
        $mois->reglements = $reglements;
        $mois->reglements = array();
        foreach($mois->factures as $facture){
            $mois->montant += $facture->montant;
            $mois->paye += $facture->paye;
            $mois->restant += $facture->restant;
            foreach($facture->reglements as $reglement) $mois->reglements[] = $reglement;
        }
        $this->set(compact('mois',"inscription"));
    }

}
