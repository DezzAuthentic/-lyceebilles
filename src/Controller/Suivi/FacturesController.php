<?php
namespace App\Controller\Suivi;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\I18n\Time;


/**
 * Factures Controller
 *
 * @property \App\Model\Table\FacturesTable $Factures
 *
 * @method \App\Model\Entity\Facture[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FacturesController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('suivi');
    } 
    
    public function index(){
        $etab = $this->getEtablissement();
        $this->loadModel('Inscriptions');
        $this->loadModel('Tuteurs');
        $user = $this->getUser();
        if($user->tuteurs){
            $tuteur = $this->Tuteurs->find('all',[
                'conditions' => ['Tuteurs.user_id'=>$user->id]
            ])->first();
        }else{
            $tuteur = $user->tuteur_secondaires[0]->tuteur;
        }

        $inscriptions = $this->Inscriptions->find('all',[
            'contain' => ['Promotions','Eleves'],
            'conditions' => ['Promotions.annee_id'=>$etab->annee_id,'Eleves.tuteur_id' => $tuteur->id]
        ]);

        $this->set(compact('inscriptions'));
    }

    public function details($facture_id=null){

        if($facture_id == null) return $this->redirect($this->referer());

        $facture = $this->Factures->get($facture_id,[
            'contain' => ['Reglements.Users.Employes','Mois','Inscriptions.Eleves','Inscriptions.Promotions','Types']
        ]);

        $this->set(compact('facture'));
    }

    public function detailsMois($inscription_id=null,$mois_id=null){

        $mois = $this->Mois->get($mois_id,[
            'contain' => ['Factures.Reglements.Users.Employes','Factures.Inscriptions.Eleves','Factures.Inscriptions.Promotions','Factures.Inscriptions' => [
                'conditions' => ['Inscriptions.id' => $inscription_id]
            ]]
        ]);

        $reglements = $this->Factures->Reglements->find('all',[
            'contain' => ['Users.Employes',"Factures"],
            'conditions' => ['Factures.inscription_id' => $inscription_id, "Factures.mois_id" => $mois_id]
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
        $this->set(compact('mois'));
    }

    public function parEleveMois($inscription_id, $month=null){
        $etab = $this->getEtablissement();
        $this->loadModel("Mois");
        $this->loadModel("Types");
        $this->loadModel("Engagements");

        $mois = $this->Mois->find('all',[
            'contain' => ['Factures.Frais.Types','Factures.Inscriptions' => [
                'conditions' => ['Inscriptions.id' => $inscription_id]
            ]]
        ]);
        $mois_list = $this->Mois->find('list',[
            'conditions' => ['Mois.etablissement_id' => $etab->id]
        ]);
        
        $inscription = $this->Factures->Inscriptions->get($inscription_id,['contain'=>['Promotions']]);
        $types = $this->Types->find("all",[
            'contain' => ['Frais.Niveaux','Frais.Series','Frais'=> [
                'conditions'=>["Frais.serie_id IS" =>$inscription->promotion->serie_id,"Frais.niveau_id" => $inscription->promotion->niveau_id]]]
        ]);
        //dd($types->toArray());

        $inscription = $this->Factures->Inscriptions->get($inscription_id,[
            'contain' => ['Eleves','Promotions']
        ]);

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

        $factureMoi = $this->Mois->find('all',[
            'contain' => ['Factures.Frais.Types','Factures.Inscriptions' => ['conditions' => ['Inscriptions.id' => $inscription_id]]],
            'conditions' => ['Mois.nom' => $month]
        ])->first();

        $totalPrev = 0;
        if($factureMoi != null){
            // Les mois précédents
            $moisPrecedents = $this->Mois->find('all',[
                'contain' => ['Factures.Frais.Types','Factures.Inscriptions' => ['conditions' => ['Inscriptions.id' => $inscription_id]]],
                'conditions' => ['Mois.ordre < ' => $factureMoi->ordre]
            ])->toArray();

            foreach($moisPrecedents as $m){
                foreach($m->factures as $f){
                    $totalPrev += $f->restant;
                } 
            }

        }

        $this->loadModel('Affectations');
        $affectation = $this->Affectations->find('all', [
            'contain' => ['Inscriptions.Eleves', 'Groupes'],
            'conditions' => ['Affectations.inscription_id' => $inscription_id]
        ])->first();


        $pdfFactures = null;
        if ($month == "all") {
            
            $intervalMonths = $this->Mois->find('all',[
                'contain' => ['Factures.Frais.Types','Factures.Inscriptions' => ['conditions' => ['Inscriptions.id' => $inscription_id]]]
            ])->toArray();
    
            $inscription = $this->Factures->Inscriptions->get($inscription_id,[
                'contain' => ['Eleves','Promotions','Affectations.Groupes']
            ]);
    
            if(isset($inscription->affectations[0])) $affectations = $this->Affectations->find('all',[
                'conditions' => ['groupe_id'=>$inscription->affectations[0]->groupe->id]
                ]);
            
            $pdfFactures = $this->Factures->find('all',[
                'contain' => ['Frais.Types','Inscriptions'],
                'conditions' => ['Inscriptions.id'=> $inscription_id]
            ])->toArray();
    
            $this->set(compact('intervalMonths','inscription','pdfFactures',"affectations"));
        }


        $this->set(compact('mois','mois_list','types','inscription', 'affectation', 'factures','total_parrain', 'factureMoi', 'moisPrecedents', 'totalPrev', 'inscription_id', 'month'));

    }

    public function imprimer($inscription_id){
        $etab = $this->getEtablissement();
        $this->loadModel("Mois");
        $this->loadModel("Types");
        $this->loadModel("Engagements");
        $this->loadModel("Affectations");

        $mois = $this->Mois->find('all',[
            'contain' => ['Factures.Frais.Types','Factures.Inscriptions' => [
                'conditions' => ['Inscriptions.id' => $inscription_id]
            ]]
        ]);
    
        $inscription = $this->Factures->Inscriptions->get($inscription_id,[
            'contain' => ['Eleves','Promotions','Affectations.Groupes']
        ]);

        if(isset($inscription->affectations[0])) $affectations = $this->Affectations->find('all',[
            'conditions' => ['groupe_id'=>$inscription->affectations[0]->groupe->id]
            ]);

        $factures = $this->Factures->find('all',[
            'contain' => ['Frais.Types','Inscriptions'],
            'conditions' => ['Inscriptions.id'=> $inscription_id,'Factures.mois_id IS' => null]
        ])->toArray();

        $this->set(compact('mois','inscription','factures',"affectations"));
    }
}
