<?php
namespace App\Controller\Boutique;

use App\Controller\AppController;
use Cake\Event\Event;
use cake\Routing\Router;
use Cake\I18n\Time;

class VentesController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('boutique');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */

    public function index()
    {
        $this->loadModel('Produits');
        $this->loadModel('Inscriptions');
        $etab = $this->getEtablissement();
        $produits = $this->Produits->find("all",[
            'contain' => ['Familles'],
            'conditions' => ["Produits.status" => 1, 'Familles.etablissement_id' => $etab->id]
        ]);
        $inscriptions = $this->Inscriptions->find('all',[
            'contain' => ['Eleves','Promotions'],
            'conditions' => ['Promotions.annee_id'=>$etab->annee_id]
        ]);

        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            if($temp["eleve_id"]=="null") $temp['eleve_id'] = null;
            $vente = $this->Ventes->newEntity();
            $vente->eleve_id = $temp['eleve_id'];
            if(isset($temp['status'])) {
                $vente->status = $temp['status'];
            }else $vente->status = 1;
            $vente->created = Time::now();
            $vente->etablissement_id = $etab->id;
            if($this->Ventes->save($vente)){
                $lignes = $temp['lignes'];
                foreach($lignes as $ligne){
                    $v_ligne = $this->Ventes->VLignes->newEntity();
                    $v_ligne->created = Time::now();
                    $v_ligne->status = 1;
                    $v_ligne->prix = $ligne['prix'];
                    $v_ligne->quantite = $ligne['quantite'];
                    $v_ligne->produit_id = $ligne['produit_id'];
                    $v_ligne->vente_id = $vente->id;
                    $this->Ventes->VLignes->save($v_ligne);
                }
                $montant = $this->totalVente($vente->id);
                if($vente->status == 3 ) $temp['paye'] = $montant;
                if($vente->status != 1 or $status != 2){
                    if(isset($temp['paye']) or $temp['paye']!=null) $this->enregistrerPaiement($vente->id,$temp["paye"]);
                }
                return $this->redirect(['action' => "fiche",$vente->id]);
            }
            //dd($temp);
        }
        $this->set(compact('produits','inscriptions'));
    }

    public function totalVente($id){
        $vente = $this->Ventes->get($id,['contain' => ['VLignes']]);
        $total=0;
        foreach($vente->v_lignes as $ligne){
            $total += $ligne->prix * $ligne->quantite;
        }
        $vente->total = $total;
        $vente->restant = $total;
        $vente->paye = 0;
        $this->Ventes->save($vente);
        return $total;
    }

    public function liste()
    {
        $etab = $this->getEtablissement();

        $ventes = $this->Ventes->find('all',[
            'contain' => ['VLignes.Produits.Familles', 'Eleves'],
            'conditions' => ['Ventes.etablissement_id' => $etab->id, 'Ventes.status IN'=>[1,2]],
            'order' => ['Ventes.created ASC']
        ]);
        //dd($ventes->toArray());
        $this->set(compact('ventes'));
    }

    public function annulees()
    {
        $etab = $this->getEtablissement();

        $ventes = $this->Ventes->find('all',[
            'contain' => ['VLignes.Produits.Familles', 'Eleves'],
            'conditions' => ['Ventes.etablissement_id' => $etab->id, 'Ventes.status' => 0],
            'order' => ['Ventes.created ASC']
        ]);
        //dd($ventes->toArray());
        $this->set(compact('ventes'));
    }

    public function effectives()
    {
        $etab = $this->getEtablissement();

        $ventes = $this->Ventes->find('all',[
            'contain' => ['VLignes.Produits.Familles', 'Eleves'],
            'conditions' => ['Ventes.etablissement_id' => $etab->id, 'Ventes.status' => 3],
            'order' => ['Ventes.created ASC']
        ]);
        //dd($ventes->toArray());
        $this->set(compact('ventes'));
    }

    public function nonSoldees()
    {
        $etab = $this->getEtablissement();

        $ventes = $this->Ventes->find('all',[
            'contain' => ['VLignes.Produits.Familles', 'Eleves'],
            'conditions' => ['Ventes.etablissement_id' => $etab->id, 'Ventes.status' => 4]
        ]);
        //dd($ventes->toArray());
        $this->set(compact('ventes'));
    }

    /**
     * View method
     *
     * @param string|null $id Professeur id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function fiche($id = null)
    {
        $vente = $this->Ventes->get($id, [
            'contain' => ['VLignes.Produits.Familles', 'Eleves']
        ]);

        $this->set('vente', $vente);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function ajouter()
    {
        if ($this->request->is('post')) {
            $vente = $this->Ventes->newEntity();
            $temp = $this->request->getData();
            $vente = $this->Ventes->patchEntity($vente, $temp);
            $lignes = $temp['lignes'];
            if ($this->Produits->save($vente)) {
                foreach($lignes as $ligne){
                    $this->enregistrerLigne();
                }
                $this->Flash->success(__("La vente a été bien enregistrée."));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__("La vente n'a pu être enregistrée. Merci de réessayer."));
        }
        return $this->redirect($this->referer());
    }

    public function modifier()
    {
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $produit = $this->Produits->get($temp['id']);
            $produit = $this->Produits->patchEntity($produit, $temp);
            if ($this->Produits->save($produit)) {
                $this->Flash->success(__("Le produit a été bien enregistré."));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__("Le produit n'a pu être enregistré. Merci de réessayer."));
        }
        return $this->redirect($this->referer());
    }

    /**
     * Edit method
     *
     * @param string|null $id Professeur id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */

    /**
     * Delete method
     *
     * @param string|null $id Professeur id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function supprimer($id = null)
    {
        try{
            $this->request->allowMethod(['post', 'delete']);

            $produit = $this->Produits->get($id);
            if ($this->Produits->delete($produit)) {
                $this->Flash->success(__("Le produit  été bien supprimé."));
            } else {
                $this->Flash->error(__("Le produit n'a pu être supprimé. Merci de réessayer."));
            }
        }catch(\Exception $e){
            $this->Flash->error(__("Impossible d'effectuer la suppression!"));
        }
        return $this->redirect($this->referer());
    }

    public function confirmer($id){
        $vente = $this->Ventes->get($id);
        $vente->status = 2;
        if($this->Ventes->save($vente)){
            $this->Flash->success("Vente confirmée avec succès.");
        }else{
            $this->Flash->success("La vente n'a pu être confirmée. Merci de réessayer.");
        }
        return $this->redirect(['action'=>'fiche',$id]);
    }

    public function annuler($id){
        $vente = $this->Ventes->get($id);
        $vente->status = 0;
        if($this->Ventes->save($vente)){
            $this->Flash->success("Vente annulée avec succès.");
        }else{
            $this->Flash->success("La vente n'a pu être annulée. Merci de réessayer.");
        }
        return $this->redirect(['action'=>'fiche',$id]);
    }

    public function cloturer($id){
        $vente = $this->Ventes->get($id);
        $vente->status = 3;
        $vente->paye = $vente->total;
        $vente->restant = 0;
        if($this->Ventes->save($vente)){
            $this->Flash->success("Vente clôturée avec succès.");
        }else{
            $this->Flash->success("La vente n'a pu être clôturée. Merci de réessayer.");
        }
        return $this->redirect(['action'=>'fiche',$id]);
    }

    public function enregistrerPaiement($id,$montant){
        $vente = $this->Ventes->get($id);
        if($montant<=0 or $montant > $vente->restant){
            $this->Flash->error("Montant du paiement non conforme. Merci de réessayer");
            return $this->redirect(['action'=>'fiche',$id]);
        } 
        $vente->paye += $montant;
        $vente->restant = $vente->total - $vente->paye;
        if($vente->restant == 0) $vente->status = 3;
        
        if($this->Ventes->save($vente)){
            $this->Flash->success("Paiement enregistré avec succès.");
        }else{
            $this->Flash->success("Le paiement n'a pu être enregistré. Merci de réessayer.");
        }
        return $this->redirect(['action'=>'fiche',$id]);
    }

    public function payer($id)
    {
        $etab = $this->getEtablissement();

        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $vente = $this->Ventes->get($id);
            
            if(isset($temp['paye'])) $this->enregistrerPaiement($vente->id,$temp["paye"]);
            return $this->redirect(['action' => "fiche",$vente->id]);
            //dd($temp);
        }
        $this->set(compact('produits','inscriptions'));
    }
}