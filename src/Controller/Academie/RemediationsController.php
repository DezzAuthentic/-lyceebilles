<?php
namespace App\Controller\Academie;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;


class RemediationsController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('academie');
    }

    public function index(){
        $etab = $this->getEtablissement();

        $remediations = $this->Remediations->find('all',[
            'contain' => ['Professeurs',"Inscriptions.Promotions","Inscriptions.Eleves",'Matieres'],
            'conditions' => ['Promotions.annee_id' => $etab->annee_id]
        ]);
        //dd($remediations->toArray());
        $this->set(compact('remediations'));
    }

    public function inscrire()
    {
        $etab = $this->getEtablissement();

        $matieres = $this->Remediations->Matieres->find('all',[
            'conditions' => ['Matieres.etablissement_id' => $etab->id]
        ]);

        $remediations = $this->Remediations->find('all',[
            'contain' => ["Inscriptions.Promotions"],
            'conditions' => ['Promotions.annee_id' => $etab->annee_id]
        ])->extract('inscription_id');
        //dd($tests->toArray());
        $en_remed = $remediations->toArray();
        $en_remed[] = 0; // pour éviter que la liste soit vide
        $inscriptions = $this->Remediations->Inscriptions->find('all',[
            'contain' => ["Promotions","Eleves"],
            'conditions' => ['Promotions.annee_id' => $etab->annee_id, "Inscriptions.id NOT IN" => $en_remed]
        ]);
        $professeurs = $this->Remediations->Professeurs->find('all',[
            'contain' => ['Enseignees.Matieres']
        ]);

        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            //dd($temp);
            $inscription_id = $temp['inscription_id'];
            $lignes = $temp['lignes'];
            $ok=1;
            foreach($lignes as $ligne){
                $remediation = $this->Remediations->newEntity();
                $remediation->created = Time::now();
                $remediation->status = 1;
                $remediation->inscription_id = $inscription_id;
                $remediation->objet = $ligne["objet"];
                //$remediation->description = $ligne["description"];
                $remediation->inscription_id = $inscription_id;
                $remediation->matiere_id = $ligne['matiere_id'];
                $remediation->professeur_id = $ligne['professeur_id'];
                if(!$this->Remediations->save($remediation)) $ok = $ok and 0;
            }
            if($ok) $this->Flash->success("Les remédiations ont été enregistrées avec succès.");
            else $this->Flash->error("Erreurs d'enregistrement. Merci de réessayer.");
            return $this->redirect(['action' => "index"]);
            //dd($temp);
        }
        $this->set(compact('inscriptions','matieres','professeurs'));
    }

    public function supprimer($id = null)
    {
        try{
            $this->request->allowMethod(['post', 'delete']);

            if ($this->Remediations->deleteAll(["inscription_id" => $id])) {
                $this->Flash->success(__("Les Remédiations de l'élève ont été bien supprimées."));
            } else {
                $this->Flash->error(__("Les remédiations de l'élève n'ont pu être supprimées. Merci de réessayer."));
            }
        }catch(\Exception $e){
            $this->Flash->error(__("Impossible d'effectuer la suppression!"));
        }
        return $this->redirect($this->referer());
    }

    public function supprimerRem($id = null)
    {
        try{
            $this->request->allowMethod(['post', 'delete']);
            $rem = $this->Remediations->get($id);
            if ($this->Remediations->delete($rem)) {
                $this->Flash->success(__("La Remédiation de l'élève a été bien supprimée."));
            } else {
                $this->Flash->error(__("La remédiation de l'élève n'a pu être supprimée. Merci de réessayer."));
            }
        }catch(\Exception $e){
            $this->Flash->error(__("Impossible d'effectuer la suppression!"));
        }
        return $this->redirect($this->referer());
    }

    public function fiche($inscription_id){
        $etab = $this->getEtablissement();
        $inscription = $this->Remediations->Inscriptions->get($inscription_id,["contain" => "Eleves"]);
        
        $remediations = $this->Remediations->find("all",[
            'contain' => ['Professeurs',"Inscriptions.Promotions",'Matieres'],
            'conditions' => ['Promotions.annee_id' => $etab->annee_id,"Remediations.inscription_id" => $inscription_id]
        ]);

        $matieres = $this->Remediations->Matieres->find('all',[
            'conditions' => ['Matieres.etablissement_id' => $etab->id]
        ]);

        $professeurs = $this->Remediations->Professeurs->find('all',[
            'contain' => ['Enseignees.Matieres']
        ]);

        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            //dd($temp);
            $lignes = $temp['remediations'];
            $ok=1;
            foreach($lignes as $ligne){
                $remediation = $this->Remediations->get($ligne['id']);
                //$remediation->note = $ligne['note'];
                //$remediation->appreciation = $ligne['appreciation'];
                if(!$this->Remediations->save($remediations)) $ok = $ok and 0;
            }
            if($ok) $this->Flash->success("Remédiations enregistrées avec succès.");
            else $this->Flash->error("Erreurs d'enregistrement. Merci de réessayer.");
            return $this->redirect(['action' => "fiche",$inscription_id]);
            //dd($temp);
        }

        $this->set(compact('inscription','matieres','professeurs',"remediations"));
    }
    
    public function modifier($inscription_id)
    {
        $etab = $this->getEtablissement();

        $matieres = $this->Remediations->Matieres->find('all',[
            'conditions' => ['Matieres.etablissement_id' => $etab->id]
        ]);

        $remediations = $this->Remediations->find('all',[
            'contain' => ["Inscriptions.Promotions","Professeurs","Matieres"],
            'conditions' => ['Promotions.annee_id' => $etab->annee_id,'Remediations.inscription_id'=>$inscription_id]
        ]);
        
        $inscription = $this->Remediations->Inscriptions->get($inscription_id, [
            'contain' => ["Promotions","Eleves"]
        ]);
        
        $professeurs = $this->Remediations->Professeurs->find('all',[
            'contain' => ['Enseignees.Matieres']
        ]);

        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            //dd($temp);
            $lignes = $temp['lignes'];
            $ok=1;
            foreach($lignes as $ligne){
                $remediation = $this->Remediations->newEntity();
                $remediation->created = Time::now();
                $remediation->status = 1;
                $remediation->inscription_id = $inscription_id;
                $remediation->objet = $ligne["objet"];
                //$remediation->description = $ligne["description"];
                $remediation->inscription_id = $inscription_id;
                $remediation->matiere_id = $ligne['matiere_id'];
                $remediation->professeur_id = $ligne['professeur_id'];
                if(!$this->Remediations->save($remediation)) $ok = $ok and 0;
            }
            if($ok) $this->Flash->success("Les remédiations ont été enregistrées avec succès.");
            else $this->Flash->error("Erreurs d'enregistrement. Merci de réessayer.");
            return $this->redirect(['action' => "fiche",$inscription_id]);
            //dd($temp);
        }
        $this->set(compact('inscription','matieres','professeurs',"remediations"));
    }
    public function seances($remediation_id){
        $etab = $this->getEtablissement();
        
        $remediation = $this->Remediations->get($remediation_id,[
            'contain' => ['Professeurs',"Inscriptions.Promotions",'Matieres',"Inscriptions.Eleves","RemediationSeances"],
        ]);
        //d($remediation);
        $this->set(compact("remediation"));

    }
    
}
