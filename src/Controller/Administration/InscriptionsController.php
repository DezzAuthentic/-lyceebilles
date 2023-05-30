<?php
namespace App\Controller\Administration;

use App\Controller\AppController;
use App\Controller\Administration\EleveController;
use Cake\Event\Event;
use Cake\I18n\Time;

/**
 * Inscriptions Controller
 *
 * @property \App\Model\Table\InscriptionsTable $Inscriptions
 *
 * @method \App\Model\Entity\Inscription[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InscriptionsController extends AppController 
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('admin');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function nouvelle()
    {   
        $etab = $this->getEtablissement();
        $this->loadModel('Types');

        $types = $this->Etablissements->Types->find("all",[
            'conditions' => ['Types.etablissement_id'=>$etab->id]
        ]);

        $tuteurs = $this->Inscriptions->Eleves->Tuteurs->find('list', [
            'conditions' => ['Tuteurs.etablissement_id'=>$etab->id],
            'order' => ['Tuteurs.nom'=>'ASC']
        ]);

        $promotions = $this->Inscriptions->Promotions->find("list",[
            'contain' => ['Niveaux'],
            'conditions' => ['Promotions.annee_id'=>$etab->annee_id]
        ]);

        $inscriptions = $this->Inscriptions->find('all',[
            'contain' => ['Promotions','Eleves'],
            'condition' => ['Promotions.annee_id'=>$etab->annee_id,]
        ]);



        $this->set(compact('tuteurs','promotions','inscriptions','types'));
    }

    public function add(){
        $this->loadModel('Factures');
        $this->loadModel('Engagements');
        $this->loadModel('Promotions');
        $this->loadModel('Frais');
        $this->loadModel('Types');
        $etab = $this->getEtablissement();
        $mois = $this->getMois();

        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            //dd($temp);
            $facultatives = null;
            if(isset($temp['facultatives'])) $facultatives = $temp['facultatives'];
            $promotion_id = $temp['promotion_id'];
            $reduction_temp = $temp['reduction'];
            $reduction_type_id = $temp['reduction_type_id'];
            $error=null;
                        
            $inscription = $this->Inscriptions->newEntity();
            $inscription->eleve_id = $temp['eleve_id'];
            $inscription->promotion_id = $promotion_id;
            $inscription->date = Time::now();
            $inscription->etat = "validé";

            //Récupération des frais de la promotion
            $promotion = $this->Promotions->get($promotion_id);
            if($promotion->serie_id)
            $types = $this->Types->find("all",[
                'contain' => [
                    'Frais'=> ['conditions'=>["Frais.niveau_id" => $promotion->niveau_id,"Frais.serie_id" => $promotion->serie_id]]
                ]
            ]);
            else
            $types = $this->Types->find("all",[
                'contain' => ['Frais'=> ['conditions'=>["Frais.niveau_id" => $promotion->niveau_id]]]
            ]);
            
            if($this->Inscriptions->save($inscription)){
                foreach($types as $type){
                    $reduction = $reduction_type_id == $type->id? $reduction_temp:0;
                    if($type->nom=="Inscription"){
                        //création d'une facture d'inscription
                        $facture_inscr = $this->Factures->newEntity();
                        $facture_inscr->inscription_id = $inscription->id;
                        $facture_inscr->type_id = $type->id;
                        $facture_inscr->date = Time::now();
                        //calcul du montant d'inscription
                        $somme_inscr=0;
                        foreach($type->frais as $frai){
                            $somme_inscr += $frai->montant;
                        }
                        $facture_inscr->montant = $somme_inscr*(100-$reduction)/100;
                        $facture_inscr->paye = 0;
                        $facture_inscr->restant = $facture_inscr->montant - $facture_inscr->paye;
                        if(!$this->Factures->save($facture_inscr)){
                            $error[] = ['inscription' => true];
                        }
                    }elseif($type->nom=="Scolarité"){
                        //calcul du montant de scolarité
                        $somme_scol=0;
                        foreach($type->frais as $frai){
                            $somme_scol += $frai->montant;
                        }
                        //création des factures de scolarité
                        foreach($mois as $moi){
                            //création d'une facture de scolarité
                            $facture_scol = $this->Factures->newEntity();
                            $facture_scol->inscription_id = $inscription->id;
                            $facture_scol->type_id = $type->id;
                            $facture_scol->date = Time::now();
                            $facture_scol->mois_id = $moi->id;                            
                            $facture_scol->montant = $somme_scol*(100-$reduction)/100;
                            $facture_scol->paye = 0;
                            $facture_scol->restant = $facture_scol->montant - $facture_scol->paye;
                            if(!$this->Factures->save($facture_scol)){
                                $error[] = ['scolarité' => true];
                            }
                        }
                    }
                }
                // Enregistrement des engagements facultatifs
               
                if($facultatives != null){
                    debug($facultatives);
                    foreach($facultatives as $fac){
                        debug($fac);
                        if($fac != 'false'){
                            $frais_fac = $this->Frais->get($fac);
                            $reduction = $reduction_type_id == $frais_fac->type_id? $reduction_temp:0;
                            $engagement = $this->Engagements->newEntity();
                            $engagement->frais_id = $fac;
                            $engagement->inscription_id = $inscription->id;
                            $engagement->debut = $etab->annee->debut;
                            $engagement->fin = $etab->annee->fin;
                            $engagement->reduction = $reduction;
                            if(!$this->Engagements->save($engagement)){
                                $error[] = ['engagement' => true];
                            }else{
                                //création des factures
                                foreach($mois as $moi){
                                    //création d'une facture
                                    $facture_eng = $this->Factures->newEntity();
                                    $facture_eng->inscription_id = $inscription->id;
                                    $facture_eng->type_id = $frais_fac->type_id;
                                    $facture_eng->date = Time::now();
                                    $facture_eng->mois_id = $moi->id;
                                    $facture_eng->montant = $frais_fac->montant*(100-$reduction)/100;
                                    $facture_eng->paye = 0;
                                    $facture_eng->restant = $facture_eng->montant - $facture_eng->paye;
                                    if(!$this->Factures->save($facture_eng)){
                                        $error[] = ['factures_engagement' => true];
                                    }
                                }
                            }
                        }
                    }
                }
                
            }

            if ($error) debug($error);

            return $this->redirect(['prefix'=>'administration','controller'=>'Inscriptions','action' => 'liste']);
        }
    }

    public function getNombre($tuteur_id){
        $this->autoRender = false;

        $inscrits = $this->Inscriptions->find('all',[
            'contain' => ['Eleves'],
            'conditions' => ['Eleves.tuteur_id'=>$tuteur_id]
        ]);

        echo json_encode($inscrits->count());                    
    }

    public function supprimer($id){
        $this->loadModel('Factures');
        $this->loadModel('Engagements');
        $this->loadModel('Reglements');

        $inscription = $this->Inscriptions->get($id);
        $reglements = $this->Reglements->find('all',[
            'contain' => ['Factures'],
            'conditions' => ['Factures.inscription_id' => $id]
        ]);
        if($reglements->count()>0){
            $this->Flash->error(__("Cette inscription ne peut être supprimée car ayant fait l'objet de réglements. Veuillez supprimer ces réglements"));
        }else{
            $this->Engagements->deleteAll(['inscription_id'=>$id]);
            $this->Factures->deleteAll(['inscription_id'=>$id]);
            $this->Inscriptions->delete($inscription);
        }
        return $this->redirect(['prefix'=>'administration','controller'=>'Inscriptions','action' => 'liste']);
    }

    function liste(){
        $etab = $this->getEtablissement();

        $inscriptions = $this->Inscriptions->find('all',[
            'contain' => ['Promotions','Eleves'],
            'condition' => ['Promotions.annee_id'=>$etab->annee_id,]
        ]);



        $this->set(compact('inscriptions'));
    }
}
