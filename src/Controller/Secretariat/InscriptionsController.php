<?php
namespace App\Controller\Secretariat;

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
        $this->viewBuilder()->setLayout('secretariat');
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
            'contain' => ['Frais'],
            'conditions' => ['Types.etablissement_id'=>$etab->id]
        ]);

        $tuteurs = $this->Inscriptions->Eleves->Tuteurs->find('list', [
            'conditions' => ['Tuteurs.etablissement_id'=>$etab->id,'Tuteurs.etat !=' => 0],
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

    public function reinitialiser($id)
    {   
        $etab = $this->getEtablissement();
        $this->loadModel('Types');

        $types = $this->Etablissements->Types->find("all",[
            'contain' => ['Frais'],
            'conditions' => ['Types.etablissement_id'=>$etab->id]
        ]);

        $inscription = $this->Inscriptions->get($id,["contain"=>['Eleves',"Promotions"]]);

        $promotions = $this->Inscriptions->Promotions->find("list",[
            'contain' => ['Niveaux'],
            'conditions' => ['Promotions.annee_id'=>$etab->annee_id]
        ]);

        $inscriptions = $this->Inscriptions->find('all',[
            'contain' => ['Promotions','Eleves'],
            'condition' => ['Promotions.annee_id'=>$etab->annee_id,]
        ]);

        $this->set(compact('tuteurs','promotions','inscriptions','inscription','types'));
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
            $promotion_id = $temp['promotion_id'];
            $reduction= $temp['reduction'];
            $error=null;
            
            //Inscription de l'élève
            $inscription = $this->Inscriptions->newEntity();
            $inscription->eleve_id = $temp['eleve_id'];
            $inscription->promotion_id = $promotion_id;
            $inscription->date = Time::now();
            $inscription->etat = "validé";

            //Récupération des frais de la promotion
            $promotion = $this->Promotions->get($promotion_id);
            if($promotion->serie_id)
            $types = $this->Types->find("all",[
                'contain' => ['Frais.Niveaux'=> ['conditions'=>["Frais.niveau_id" => $promotion->niveau_id]],
                    'Frais.Series'=> ['conditions'=>["Frais.serie_id" => $promotion->serie_id]]],
                'conditions' => ['Types.obligatoire'=>1,'Types.selection'=>0]
            ]);
            else
            $types = $this->Types->find("all",[
                'contain' => ['Frais.Niveaux'=> ['conditions'=>["Frais.niveau_id" => $promotion->niveau_id]]],
                'conditions' => ['Types.obligatoire'=>1,'Types.selection'=>0]
            ]);


            if($this->Inscriptions->save($inscription)){
                foreach($types as $type){
                    $reduct = $reduction['type_id'] == $type->id? $reduction['pourcentage']:0;
                    $reduct_all = $reduction['type_id']=='tout'? $reduction['pourcentage']:0;

                    foreach($type->frais as $frai){
                        $this->enregistrerF($inscription,$frai,$type->recurrence,$reduct,$reduct_all,$mois,$etab);
                    }
                
                }
                    
                   
                if(isset($temp['types_tout'])){
                    foreach($temp['types_tout'] as $type){
                        
                        if($promotion->serie_id)
                        $type = $this->Types->get($type,[
                            'contain' => ['Frais.Niveaux'=> ['conditions'=>["Frais.niveau_id" => $promotion->niveau_id]],
                                'Frais.Series'=> ['conditions'=>["Frais.serie_id" => $promotion->serie_id]]]
                        ]);
                        else
                        $type = $this->Types->get($type,[
                            'contain' => ['Frais.Niveaux'=> ['conditions'=>["Frais.niveau_id" => $promotion->niveau_id]]]
                        ]);

                        $reduct = $reduction['type_id'] == $type->id? $reduction['pourcentage']:0;
                        $reduct_all = $reduction['type_id']=='tout'? $reduction['pourcentage']:0;
                        

                        foreach($type->frais as $frai){
                            $this->enregistrerF($inscription,$frai,$type->recurrence,$reduct,$reduct_all,$mois,$etab);
                        }
                    }
                }
                if(isset($temp['frais_uniques'])){
                    foreach($temp['frais_uniques'] as $frais){
                        if($frais!='null'){
                            $frai = $this->Frais->get($frais,['contain'=>['Types']]);

                            $reduct = $reduction['type_id'] == $frai->type_id? $reduction['pourcentage']:0;
                            $reduct_all = $reduction['type_id']=='tout'? $reduction['pourcentage']:0;
                            
                            $this->enregistrerF($inscription,$frai,$frai->type->recurrence,$reduct,$reduct_all,$mois,$etab);
                        }
                    }
                }
                if(isset($temp['frais_multis'])){
                    foreach($temp['frais_multis'] as $frais){
                        $frai = $this->Frais->get($frais,['contain'=>['Types']]);

                        $reduct = $reduction['type_id'] == $frai->type_id? $reduction['pourcentage']:0;
                        $reduct_all = $reduction['type_id']=='tout'? $reduction['pourcentage']:0;
                        
                        $this->enregistrerF($inscription,$frai,$frai->type->recurrence,$reduct,$reduct_all,$mois,$etab);
                    }
                }
                    

            }

            //if ($error) debug($error);

            return $this->redirect(['controller'=>'Inscriptions','action' => 'liste']);
        }
    }

    public function init(){
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
            $promotion_id = $temp['promotion_id'];
            $inscription_id = $temp['inscription_id'];
            $reduction= $temp['reduction'];
            $error=null;

            //Suppression des anciennes factures et anciens engagements
            try{
                $factures = $this->Factures->find('all',[
                    'conditions' => ['Factures.inscription_id'=>$inscription_id]
                ]);
                foreach($factures as $facture){
                    $this->Factures->Reglements->deleteAll(["facture_id"=>$facture->id]);
                    $this->Factures->delete($facture);
                }
                $this->Engagements->deleteAll(["inscription_id"=>$inscription_id]);
            }catch(\Exception $e){
                $this->Flash->error(__("Impossible d'effectuer la suppression!"));
                $this->redirect($this->referer());
            }
            
            //Récupération de l'inscription de l'élève
            $inscription = $this->Inscriptions->get($inscription_id);
            $inscription->promotion_id = $promotion_id;

            //Récupération des frais de la promotion
            $promotion = $this->Promotions->get($promotion_id);
            $types = $this->Types->find("all",[
                'contain' => ['Frais'=> [
                    'conditions'=>["Frais.niveau_id" => $promotion->niveau_id,'Frais.serie_id IS'=>$promotion->serie_id]
                ]],
                'conditions' => ['Types.obligatoire'=>1,'Types.selection'=>0]
            ]);

            if($this->Inscriptions->save($inscription)){
                foreach($types as $type){
                    $reduct = $reduction['type_id'] == $type->id? $reduction['pourcentage']:0;
                    $reduct_all = $reduction['type_id']=='tout'? $reduction['pourcentage']:0;
                    
                    foreach($type->frais as $frai){
                        $this->enregistrerF($inscription,$frai,$type->recurrence,$reduct,$reduct_all,$mois,$etab);
                    }
                }
                   
                if(isset($temp['types_tout'])){
                    foreach($temp['types_tout'] as $type){
                        
                        if($promotion->serie_id)
                        $type = $this->Types->get($type,[
                            'contain' => ['Frais.Niveaux'=> ['conditions'=>["Frais.niveau_id" => $promotion->niveau_id]],
                                'Frais.Series'=> ['conditions'=>["Frais.serie_id" => $promotion->serie_id]]]
                        ]);
                        else
                        $type = $this->Types->get($type,[
                            'contain' => ['Frais.Niveaux'=> ['conditions'=>["Frais.niveau_id" => $promotion->niveau_id]]]
                        ]);

                        $reduct = $reduction['type_id'] == $type->id? $reduction['pourcentage']:0;
                        $reduct_all = $reduction['type_id']=='tout'? $reduction['pourcentage']:0;
                        
                        foreach($type->frais as $frai){
                            $this->enregistrerF($inscription,$frai,$type->recurrence,$reduct,$reduct_all,$mois,$etab);
                        }
                    }
                }
                if(isset($temp['frais_uniques'])){
                    foreach($temp['frais_uniques'] as $frais){
                        if($frais!='null'){
                            $frai = $this->Frais->get($frais,['contain'=>['Types']]);

                            $reduct = $reduction['type_id'] == $frai->type_id? $reduction['pourcentage']:0;
                            $reduct_all = $reduction['type_id']=='tout'? $reduction['pourcentage']:0;
                            
                            $this->enregistrerF($inscription,$frai,$frai->type->recurrence,$reduct,$reduct_all,$mois,$etab);
                        }
                    }
                }
                if(isset($temp['frais_multis'])){
                    foreach($temp['frais_multis'] as $frais){
                        $frai = $this->Frais->get($frais,['contain'=>['Types']]);

                        $reduct = $reduction['type_id'] == $frai->type_id? $reduction['pourcentage']:0;
                        $reduct_all = $reduction['type_id']=='tout'? $reduction['pourcentage']:0;
                        
                        $this->enregistrerF($inscription,$frai,$frai->type->recurrence,$reduct,$reduct_all,$mois,$etab);
                    }
                }
            }

            return $this->redirect(['controller'=>'Inscriptions','action' => 'liste']);
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
        $this->loadModel('PeriodeBulletins');

        try{
            $inscription = $this->Inscriptions->get($id,[
                'contain' => ['Affectations.AnneeBulletins','Affectations.PeriodeBulletins.PeriodeBulletinLignes',
                    'Factures.Reglements','Engagements']
            ]);

            foreach($inscription->affectations as $affectation){
                foreach($affectation->periode_bulletins as $bulletin){
                    $this->PeriodeBulletins->PeriodeBulletinLignes->deleteAll(['periode_bulletin_id'=> $bulletin->id]);
                    $$this->PeriodeBulletins->delete($bulletin);
                }
                $this->Inscriptions->Affectations->AnneeBulletins->deleteAll(["affectation_id"=>$affectation->id]);
                $this->Inscriptions->Affectations->delete($affectation);
            }
            foreach($inscription->factures as $facture){
                $this->Factures->Reglements->deleteAll(["facture_id"=>$facture->id]);
                $this->Factures->delete($facture);
            }
            $this->Engagements->deleteAll(["inscription_id"=>$id]);
            $this->Inscriptions->delete($inscription);

        }catch(\Exception $e){
            $this->Flash->error(__("Impossible d'effectuer la suppression!"));
            dd($e);
            $this->redirect($this->referer());
        }


        return $this->redirect($this->referer());
    }

    public function liste(){
        $etab = $this->getEtablissement();

        $inscriptions = $this->Inscriptions->find('all',[
            'contain' => ['Promotions','Eleves'],
            'conditions' => ['Promotions.annee_id'=>$etab->annee_id]
        ]);



        $this->set(compact('inscriptions'));
    }

    public function enregistrerFO($inscription,$type,$reduct,$reduct_all,$mois,$etab){
        if($type->recurrence==0){
            foreach($type->frais as $frai){
                //création d'une facture
                $facture = $this->Factures->newEntity();
                $facture->inscription_id = $inscription->id;
                $facture->frais_id = $frai->id;
                $facture->date = Time::now();
                $temp_montant = $frai->montant*(100-($reduct+$reduct_all))/100;
                $facture->montant = $temp_montant;
                $facture->paye = 0;
                $facture->restant = $facture->montant - $facture->paye;
                $this->Factures->save($facture);
            }
        }else{
            $frais = $type->frais;
            foreach($frais as $frai){
            //Enregistrement des engagements
                $engagement = $this->Engagements->newEntity();
                $engagement->frais_id = $frai->id;
                $engagement->inscription_id = $inscription->id;
                $engagement->debut = $etab->annee->debut;
                $engagement->fin = $etab->annee->fin;
                $engagement->reduction = $reduct + $reduct_all;
                if($this->Engagements->save($engagement)){
                    //création des factures
                    foreach($mois as $moi){
                        //création d'une facture
                        $facture = $this->Factures->newEntity();
                        $facture->inscription_id = $inscription->id;
                        $facture->frais_id = $frai->id;
                        $facture->date = Time::now();
                        $facture->mois_id = $moi->id;
                        $temp_montant = $frai->montant*(100-$engagement->reduction)/100;
                        $facture->montant = $temp_montant;
                        $facture->paye = 0;
                        $facture->restant = $facture->montant - $facture->paye;
                        $this->Factures->save($facture);
                    }
                }
            }
        }
    }

    public function enregistrerF($inscription,$frai,$recurrence,$reduct,$reduct_all,$mois,$etab){
        if($recurrence==0){
            //création d'une facture
            $facture = $this->Factures->newEntity();
            $facture->inscription_id = $inscription->id;
            $facture->frais_id = $frai->id;
            $facture->date = Time::now();
            $temp_montant = $frai->montant*(100-($reduct+$reduct_all))/100;
            $facture->montant = $temp_montant;
            $facture->paye = 0;
            $facture->restant = $facture->montant - $facture->paye;
            $this->Factures->save($facture);
        }else{
            $engagement = $this->Engagements->newEntity();
            $engagement->frais_id = $frai->id;
            $engagement->inscription_id = $inscription->id;
            $engagement->debut = $etab->annee->debut;
            $engagement->fin = $etab->annee->fin;
            $engagement->reduction = $reduct + $reduct_all;
            if($this->Engagements->save($engagement)){
                //création des factures
                foreach($mois as $moi){
                    //création d'une facture
                    $facture = $this->Factures->newEntity();
                    $facture->inscription_id = $inscription->id;
                    $facture->engagement_id = $engagement->id;
                    $facture->frais_id = $frai->id;
                    $facture->date = Time::now();
                    $facture->mois_id = $moi->id;
                    $temp_montant = $frai->montant*(100-$engagement->reduction)/100;
                    $facture->montant = $temp_montant;
                    $facture->paye = 0;
                    $facture->restant = $facture->montant - $facture->paye;
                    $this->Factures->save($facture);
                }
            }
        }

    }

    public function desactiver($id){
        $inscription = $this->Inscriptions->get($id);
        $inscription->etat = "suspendu";
        $this->Inscriptions->save($inscription);
        $this->redirect($this->referer()); 
    }
    public function activer($id){
        $inscription = $this->Inscriptions->get($id);
        $inscription->etat = "validé";
        $this->Inscriptions->save($inscription);
        $this->redirect($this->referer()); 
    }
}
