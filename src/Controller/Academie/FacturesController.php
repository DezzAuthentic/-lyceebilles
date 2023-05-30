<?php
namespace App\Controller\Academie;

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
        $this->viewBuilder()->setLayout('academie');
    } 
    
    public function parEleve($inscription_id){
        $etab = $this->getEtablissement();
        $this->loadModel("Types");
        $types = $this->Types->find('all',[
            'contain' => ['Factures.Mois','Factures.Inscriptions' => [
                'conditions' => ['Inscriptions.id' => $inscription_id]
            ]]
        ]);

        $inscription = $this->Factures->Inscriptions->get($inscription_id,[
            'contain' => ['Eleves','Promotions']
        ]);

        // dd($types->toArray());

        $this->set(compact('types','inscription'));
    }

    public function details($facture_id=null){

        if($facture_id == null) return $this->redirect($this->referer());

        $facture = $this->Factures->get($facture_id,[
            'contain' => ['Reglements.Users.Employes','Mois','Inscriptions.Eleves','Inscriptions.Promotions','Frais.Types']
        ]);

        $this->set(compact('facture'));
    }

    public function detailsMois($inscription_id=null,$mois_id=null){

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
        $this->set(compact('mois'));
    }

    public function parEleveMois($inscription_id, $month=null){
        $etab = $this->getEtablissement();
        $this->loadModel("Mois");
        $this->loadModel("Types");
        $this->loadModel("Engagements");
        $this->loadModel('Affectations');

        $mois = $this->Mois->find('all',[
            'contain' => ['Factures.Frais.Types','Factures.Inscriptions' => [
                'conditions' => ['Inscriptions.id' => $inscription_id]
            ]]
        ]);
        $mois_list = $this->Mois->find('list');
        
        $inscription = $this->Factures->Inscriptions->get($inscription_id,['contain'=>['Promotions']]);
        $types = $this->Types->find("all",[
            'contain' => ['Frais.Niveaux','Frais.Series','Frais'=> [
                'conditions'=>[
                    "Frais.serie_id IS" =>$inscription->promotion->serie_id,
                    "Frais.niveau_id" => $inscription->promotion->niveau_id
                    ]
                ]
            ],
            "conditions" => ['Types.etablissement_id' => $etab->id]
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
            'contain' => [
                'Factures.Frais.Types',
                'Factures.Inscriptions' => [
                    'conditions' => [
                        'Inscriptions.id' => $inscription_id
                        ]
                    ]
                ],
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
        
        

        $affectation = $this->Affectations->find('all', [
            'contain' => ['Inscriptions.Eleves', 'Groupes'],
            'conditions' => ['Affectations.inscription_id' => $inscription_id]
        ])->first();

        $ordre1 = null; $ordre2 = null; $pdfFactures = null;
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $ordre1 = $temp['debut'];
            $ordre2 = $temp['fin'];

            $intervalMonths = [];

            if($ordre1 != 0 && $ordre2 != 0){
                $lesMois = $this->Mois->find('all',[
                    'contain' => ['Factures.Frais.Types','Factures.Inscriptions' => [
                        'conditions' => ['Inscriptions.id' => $inscription_id]
                    ]],
                    'conditions' => ['Mois.ordre >=' => $ordre1, 'Mois.ordre <=' => $ordre2]
                ])->toArray();
            }elseif($ordre1 == 0 && $ordre2 != 0){
                $lesMois = $this->Mois->find('all',[
                    'contain' => ['Factures.Frais.Types','Factures.Inscriptions' => [
                        'conditions' => ['Inscriptions.id' => $inscription_id]
                    ]],
                    'conditions' => ['Mois.ordre >=' => 3, 'Mois.ordre <=' => $ordre2]
                ])->toArray();
            }else {
                $lesMois = $mois;
            }
            

            foreach($lesMois as $month){
                if($month->factures != null){
                    $intervalMonths[] = $month;
                }
            }

    
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

        $onlyInscription = '';
        if($ordre1 == 0 && $ordre2 == 0){
            $onlyInscription = "ok";
        }

        //dd($factureMoi);

        $this->set(compact('mois','mois_list','types', 'onlyInscription', 'inscription','factures', 'moisPrecedents', 'totalPrev', 'total_parrain', 'inscription_id', 'factureMoi', 'affectation', 'month', 'pdfFactures'));
    }

    public function imprimer($inscription_id,$ordre1=null,$ordre2=null){
        $etab = $this->getEtablissement();
        $this->loadModel("Mois");
        $this->loadModel("Types");
        $this->loadModel("Engagements");
        $this->loadModel("Affectations");

        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $ordre1 = $temp['debut'];
            $ordre2 = $temp['fin'];
        }

        $mois = $this->Mois->find('all',[
            'contain' => ['Factures.Frais.Types','Factures.Inscriptions' => [
                'conditions' => ['Inscriptions.id' => $inscription_id]
            ]],
            'conditions' => ['Mois.ordre >=' => $ordre1, 'Mois.ordre <=' => $ordre2]
        ]);

        $inscription = $this->Factures->Inscriptions->get($inscription_id,[
            'contain' => ['Eleves','Promotions','Affectations.Groupes']
        ]);

        if(isset($inscription->affectations[0])) $affectations = $this->Affectations->find('all',[
            'conditions' => ['groupe_id'=>$inscription->affectations[0]->groupe->id]
            ]);
        $factures = null;
        if($ordre1==0){
            $factures = $this->Factures->find('all',[
                'contain' => ['Frais.Types','Inscriptions'],
                'conditions' => ['Inscriptions.id'=> $inscription_id,'Factures.mois_id IS' => null]
            ])->toArray();
        }

        $this->set(compact('mois','inscription','factures',"affectations"));
    }

    public function parrainage($inscription_id){
        
    }

    public function libre(){
        if ($this->request->is('post')) {
            $facture = $this->Factures->newEntity();
            $temp = $this->request->getData();
            $facture = $this->Factures->patchEntity($facture,$temp);
            $facture->date = Time::now();
            $facture->paye = 0;
            $facture->restant = $facture->montant;
            if(!$this->Factures->save($facture)){
                $this->Flash->error("Une erreur est survenue. La facture n'a pu être enregistrée.");
                dd($facture);
            }
        }
        return $this->redirect($this->referer());
    }
    public function supprimer($id){
        $this->loadModel('Reglements');

        $facture = $this->Factures->get($id);
        $reglements = $this->Reglements->find('all',[
            'conditions' => ['Reglements.facture_id' => $id]
        ]);
        if($reglements->count()>0){
            $this->Flash->error(__("Cette facture ne peut être supprimée car ayant fait l'objet de réglements. Veuillez annuler ces réglements"));
        }else{
            $this->Factures->delete($facture);
        }
        return $this->redirect($this->referer());
    }

    function classe($id, $idMois=null, $type=null){
        $etab = $this->getEtablissement();
        $this->loadModel("Groupes");
        $this->loadModel('Mois');
        $factureMoi = [];

        $groupe = $this->Groupes->get($id,[
            "contain" => ['Affectations.Inscriptions.Eleves']
        ]);


        $mois = $this->Mois->find('all', [
            'contain' => ['Factures.Frais.Types','Factures.Inscriptions', 'Factures.Inscriptions.Eleves']
        ]);
        
        $moisPrecedents = []; 

        if($idMois != null && $type=="all"){
            $factureMoi = $this->Mois->find('all',[
                'contain' => ['Factures.Frais.Types','Factures.Inscriptions', 'Factures.Inscriptions.Eleves'],
                'conditions' => ['Mois.id' => $idMois]
            ])->first();

            $allFactures = [];
        
            foreach($groupe->affectations as $affectation){
                foreach($factureMoi->factures as $facture){
                    if($facture->inscription_id == $affectation->inscription->id){
                        $allFactures[] = $facture;
                    }
                }
            }
            $leMois = $this->Mois->get($idMois);

            $totalPrev = 0;
            if($factureMoi != null){
                // Les mois précédents
                $moisPrecedents = $this->Mois->find('all',[
                    'contain' => ['Factures.Frais.Types','Factures.Inscriptions', 'Factures.Inscriptions.Eleves'],
                    'conditions' => ['Mois.ordre < ' => $factureMoi->ordre]
                ])->toArray();
                

            }

        }

        $affectations = $groupe->affectations;
        $lastAffectation = end($affectations);


        $this->set(compact('groupe', 'mois', 'allFactures', 'leMois', 'factureMoi', 'lastAffectation', 'moisPrecedents'));
    }

    public function index(){
        $this->loadModel('Groupes');
        $etab = $this->getEtablissement();

        $groupes = $this->Groupes->find('all',[
            'contain' => ['Promotions.Niveaux','Affectations','Promotions.Inscriptions'],
            'conditions' => ['Promotions.annee_id'=> $etab->annee_id],
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
        $this->set(compact('groupes','effectifs'));
    }

    public function modifier($inscription_id){
        $this->loadModel("Engagements");
        $this->loadModel("Types");
        $this->loadModel("Mois");
        $etab = $this->getEtablissement();

        $inscription = $this->Factures->Inscriptions->get($inscription_id,[
            'contain' => ['Eleves','Promotions']
        ]);

        $engagements = $this->Engagements->find("all",[
            "contain" => ['Frais'],
            'conditions' => ['Engagements.inscription_id' => $inscription_id]
        ]);
        $frais = $this->Engagements->find("all",[
            "contain" => ['Frais'],
            'conditions' => ['Engagements.inscription_id' => $inscription_id]
        ])->extract("frais_id")->toArray();

        $types = $this->Types->find("all",[
            'contain' => ['Frais.Niveaux','Frais.Series','Frais'=> [
                'conditions'=>["Frais.serie_id IS" =>$inscription->promotion->serie_id,"Frais.niveau_id" => $inscription->promotion->niveau_id]]],
            "conditions" => ['Types.etablissement_id' => $etab->id]
        ]);

        $mois_list = $this->Mois->find('list');
        $mois = $this->Mois->find('all');

        $this->set(compact('inscription','engagements','mois_list','types','mois'));
    }

    

}
