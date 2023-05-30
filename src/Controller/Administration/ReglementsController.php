<?php
namespace App\Controller\Administration;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;

/**
 * Reglements Controller
 *
 * @property \App\Model\Table\ReglementsTable $Reglements
 *
 * @method \App\Model\Entity\Reglement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReglementsController extends AppController
{

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $reglement = $this->Reglements->newEntity();
        if ($this->request->is('post')) {
            $reglement = $this->Reglements->patchEntity($reglement, $this->request->getData());
            $reglement->date = Time::now();
            $reglement->user_id = $this->Auth->user('id');
            $facture = $this->Reglements->Factures->get($reglement->facture_id);
            if($facture->restant < $reglement->montant) {
                $this->Flash->error(__("Le montant saisi est supérieur au montant à payer."));
                return $this->redirect($this->referer());
            }
            if ($this->Reglements->save($reglement)) {
                $facture = $this->Reglements->Factures->get($reglement->facture_id);
                $facture->paye = $facture->paye + $reglement->montant;
                $facture->restant = $facture->montant - $facture->paye;
                if(!$this->Reglements->Factures->save($facture)){
                    $this->Reglements->delete($reglement);
                }
            }
        }
        return $this->redirect($this->referer());

    }

    public function mois()
    {
        
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $inscription_id = $temp['inscription_id'];
            $mois_id = $temp['mois_id'];
            $montant = $temp['montant'];
            $moyen = $temp['moyen'];
            
            $factures = $this->Reglements->Factures->find('all',[
                "conditions" => ["Factures.inscription_id" => $inscription_id, "Factures.mois_id" => $mois_id]
            ]);
            foreach($factures as $facture){
                if($montant<=0) break;
                $apayer = $montant > $facture->restant?$facture->restant:$montant;
                $reglement = $this->Reglements->newEntity();
                $reglement->date = Time::now();
                $reglement->user_id = $this->Auth->user('id');
                $reglement->facture_id = $facture->id;
                $reglement->montant = $apayer;
                $reglement->moyen = $moyen;
                //debug($reglement);
                if ($this->Reglements->save($reglement)) {
                    $facture->paye = $facture->paye + $reglement->montant;
                    $facture->restant = $facture->montant - $facture->paye;
                    if(!$this->Reglements->Factures->save($facture)){
                        $this->Reglements->delete($reglement);
                    }
                }
                $montant = $montant - $reglement->montant;
            }
        }
        return $this->redirect($this->referer());

    }

   
}
