<?php
namespace App\Controller\Administration;

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
        $this->viewBuilder()->setLayout('admin');
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
        /*$mois->reglements = array();
        foreach($mois->factures as $facture){
            $mois->montant += $facture->montant;
            $mois->paye += $facture->paye;
            $mois->restant += $facture->restant;
            foreach($facture->reglements as $reglement) $mois->reglements[] = $reglement;
        }*/
        $this->set(compact('mois'));
    }

    public function parEleveMois($inscription_id){
        $etab = $this->getEtablissement();
        $this->loadModel("Mois");
        $this->loadModel("Types");

        $mois = $this->Mois->find('all',[
            'contain' => ['Factures.Types','Factures.Inscriptions' => [
                'conditions' => ['Inscriptions.id' => $inscription_id]
            ]]
        ]);
        $mois_list = $this->Mois->find('list',[
            'conditions' => ['Mois.etablissement_id' => $etab->id]
        ]);
        $types_list = $this->Types->find('list',[
            'conditions' => ['Types.etablissement_id' => $etab->id]
        ]);
        

        $inscription = $this->Factures->Inscriptions->get($inscription_id,[
            'contain' => ['Eleves','Promotions']
        ]);

        $factures = $this->Factures->find('all',[
            'contain' => ['Types','Inscriptions'],
            'conditions' => ['Inscriptions.id'=> $inscription_id,'Factures.mois_id IS' => null]
        ]);

        //$this->viewBuilder()->setClassName('CakePdf.Pdf');
        /*$this->viewBuilder()->options([
            'pdfConfig' => [
                'download' => true, // This can be omitted if "filename" is specified.
                'filename' => 'Invoice_' . $inscription_id // This can be omitted if you want file name based on URL.
            ]
        ]);*/

        // dd($types->toArray());

        $this->set(compact('mois','mois_list','types_list','inscription','factures'));
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
}
