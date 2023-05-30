<?php
namespace App\Controller\Finance;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\I18n\Time;
/**
 * Engagements Controller
 *
 *
 * @method \App\Model\Entity\Engagement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EngagementsController extends AppController
{
    public function ajouter(){

        $this->loadModel('Mois');
        $this->loadModel('Factures');
        $this->loadModel('Frais');
        $etab = $this->getEtablissement();

        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $debut = $this->Mois->get($temp['debut']);
            $fin = $this->Mois->get($temp['fin']);
            $frai = $this->Frais->get($temp['frais_id']);
            if($debut->ordre > $fin->ordre){
                $this->Flash->error('Il y a erreur dans le choix de la période. Merci de réessayer.');  
                return $this->redirect($this->referer());
            }
            $engagement = $this->Engagements->newEntity();
            $engagement->frais_id = $temp['frais_id'];
            $engagement->inscription_id = $temp['inscription_id'];
            $engagement->debut = $debut->id;
            $engagement->fin = $fin->id;
            $engagement->reduction = $temp['reduction'];
            if($this->Engagements->save($engagement)){
                $mois = $this->Mois->find('all',[
                    'conditions' => ['Mois.etablissement_id'=>$etab->id,'Mois.ordre >=' => $debut->ordre,'Mois.ordre <=' => $fin->ordre]
                ]);
                //création des factures
                foreach($mois as $moi){
                    //création d'une facture
                    $facture = $this->Factures->newEntity();
                    $facture->inscription_id = $temp['inscription_id'];
                    $facture->engagement_id = $engagement->id;
                    $facture->frais_id = $temp['frais_id'];
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
        return $this->redirect($this->referer());
    }

    public function modifier(){
        $this->loadModel('Mois');
        $this->loadModel('Frais');
        $this->loadModel('Reglements');
        $etab = $this->getEtablissement();

        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            //debug($temp);
            $engagement = $this->Engagements->get($temp["id"]);
            $fin_old= $this->Mois->get($engagement->fin);
            $fin_new = $this->Mois->get($temp["fin"]);
            $engagement = $this->Engagements->patchEntity($engagement, $temp);
            $mois = $this->Mois->find('all',[
                'conditions' => ['Mois.etablissement_id'=>$etab->id]
            ]);
            //dd($mois->toArray());
            $frai = $this->Frais->get($engagement->frais_id);
            $factures = $this->Engagements->Factures->find('all',[
                'contain' => ['Mois'],
                'conditions' => ['Factures.engagement_id'=>$engagement->id]
            ]);
            if ($this->Engagements->save($engagement)) {
                foreach($factures as $facture){
                    if($facture->mois->ordre > $fin_new->ordre){
                        $this->Reglements->deleteAll(["facture_id"=>$facture->id]);
                        $this->Engagements->Factures->delete($facture);
                    }
                }
                if($fin_old->ordre < $fin_new->ordre){
                    foreach($mois as $moi){
                        if($moi->ordre > $fin_old->ordre and $moi->ordre <= $fin_new->ordre){
                            $facture = $this->Engagements->Factures->newEntity();
                            $facture->inscription_id = $engagement->inscription_id;
                            $facture->engagement_id = $engagement->id;
                            $facture->frais_id = $engagement->frais_id;
                            $facture->date = Time::now();
                            $facture->mois_id = $moi->id;
                            $temp_montant = $frai->montant*(100-$engagement->reduction)/100;
                            $facture->montant = $temp_montant;
                            $facture->paye = 0;
                            $facture->restant = $facture->montant - $facture->paye;
                            $this->Engagements->Factures->save($facture);
                        }
                    }
                }
                return $this->redirect($this->referer());
            }
        }
    }

    public function supprimer(){
        $this->loadModel('Reglements');
        try{
            if ($this->request->is('post')) {
                $temp = $this->request->getData();
                $engagement = $this->Engagements->get($temp['id']);
                $factures = $this->Engagements->Factures->find('all',[
                    'conditions' => ['Factures.engagement_id'=>$temp['id']]
                ]);
                foreach($factures as $facture){
                    $this->Reglements->deleteAll(["facture_id"=>$facture->id]);
                    $this->Engagements->Factures->delete($facture);
                }
                $this->Engagements->delete($engagement);
            }
        }catch(\Exception $e){
            $this->Flash->error(__("Impossible d'effectuer la suppression!"));
        }
        return $this->redirect($this->referer());
    }
    
}
