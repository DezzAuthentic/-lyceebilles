<?php
namespace App\Controller\Secretariat;

use App\Controller\AppController;
use Cake\Event\Event;
use cake\Routing\Router;

class FichesMedicalesController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('secretariat');
    }

    public function index(){
        $etab = $this->getEtablissement();

        $eleves = $this->Etablissements->Eleves->find('all',[
            'contain' => ['Users','Renseignement_valeurs','Inscriptions.Affectations.Groupes', 'Inscriptions.Promotions' =>[
                    'conditions' =>['Promotions.annee_id'=>$etab->annee_id]
                ]
            ],
            'conditions' => ['Eleves.etablissement_id'=>$etab->id,'Eleves.etat !=' => 0]
        ]);
        $this->set(compact('eleves'));
    }

    public function fiche($eleve_id){
        $this->loadModel('RenseignementTypes');
        $this->loadModel('Eleves');
        $etab = $this->getEtablissement();

        $eleve = $this->Eleves->get($eleve_id,[
            'contain' => ["Tuteurs.TuteurSecondaires",'Inscriptions.Affectations.Groupes', 'Inscriptions.Promotions' => [
                'conditions' =>['Promotions.annee_id'=>$etab->annee_id]
                ]
            ]
        ]);

        $types = $this->RenseignementTypes->find('All',[
            "contain" => [
                'Renseignements' => ["conditions" => ['Renseignements.status'=> 1]],
                'Renseignements.RenseignementValeurs' => ["conditions" => ['RenseignementValeurs.eleve_id'=> $eleve_id]],
            ],
            "conditions" => ['RenseignementTypes.etablissement_id'=>$etab->id,'RenseignementTypes.status'=>1]
        ]);

        //dd($types->toArray());
        $this->set(compact('eleve','types'));
        
    }

    public function enregistrer($eleve_id){
        $this->loadModel('RenseignementTypes');
        $this->loadModel('Eleves');
        $etab = $this->getEtablissement();

        $eleve = $this->Eleves->get($eleve_id,[
            'contain' => ["Tuteurs.TuteurSecondaires",'Inscriptions.Affectations.Groupes', 'Inscriptions.Promotions' => [
                'conditions' =>['Promotions.annee_id'=>$etab->annee_id]
                ]
            ]
        ]);
        $types = $this->RenseignementTypes->find('All',[
            "contain" => [
                'Renseignements' => ["conditions" => ['Renseignements.status'=> 1]],
                'Renseignements.RenseignementValeurs' => ["conditions" => ['RenseignementValeurs.eleve_id'=> $eleve_id]],
            ],
            "conditions" => ['RenseignementTypes.etablissement_id'=>$etab->id,'RenseignementTypes.status'=>1]
        ]);
        //dd($types->toArray());
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $rep = true;
            foreach($temp['renseignements'] as $renseignement){
                $renseignement_id = $renseignement['renseignement_id'];
                $valeur = isset($renseignement['valeur'])?$renseignement['valeur']:null;
                $commentaire = isset($renseignement['commentaire'])?$renseignement['commentaire']:null;
                $rep = $rep and $this->enregistrerRenseignement($renseignement_id,$valeur,$commentaire,$eleve_id);
            }
            if($rep){
                $this->Flash->success("La fiche a été enregistrée avec succès.");
            }else{
                $this->Flash->error("Il y a eu quelques erreurs dans l'enregistrement de la fiche.");
            }
            $this->redirect(['action'=> 'fiche',$eleve_id]);
        }
        $this->set(compact('eleve','types'));
    }

    public function enregistrerRenseignement($renseignement_id,$valeur,$commentaire,$eleve_id){
        $this->loadModel('RenseignementValeurs');
        $renseignement = $this->RenseignementValeurs->find('all',[
            'conditions' => ['RenseignementValeurs.renseignement_id' => $renseignement_id,'RenseignementValeurs.eleve_id' => $eleve_id]
        ])->first();
        if($renseignement) {
            $renseignement->valeur = $valeur;
            $renseignement->commentaire = $commentaire;
        }else{
            $renseignement = $this->RenseignementValeurs->newEntity();
            $renseignement->eleve_id = $eleve_id;
            $renseignement->renseignement_id = $renseignement_id;
            $renseignement->valeur = $valeur;
            $renseignement->commentaire = $commentaire;
        }
        if($this->RenseignementValeurs->save($renseignement)) return true;
        return false;
    }

    public function modifier($eleve_id){
        $this->loadModel('RenseignementTypes');
        $this->loadModel('Eleves');
        $etab = $this->getEtablissement();

        $eleve = $this->Eleves->get($eleve_id,[
            'contain' => ["Tuteurs.TuteurSecondaires",'Inscriptions.Affectations.Groupes', 'Inscriptions.Promotions' => [
                'conditions' =>['Promotions.annee_id'=>$etab->annee_id]
                ]
            ]
        ]);
        $types = $this->RenseignementTypes->find('All',[
            "contain" => [
                'Renseignements' => ["conditions" => ['Renseignements.status'=> 1]],
                'Renseignements.RenseignementValeurs' => ["conditions" => ['RenseignementValeurs.eleve_id'=> $eleve_id]],
            ],
            "conditions" => ['RenseignementTypes.etablissement_id'=>$etab->id,'RenseignementTypes.status'=>1]
        ]);
        //dd($types->toArray());
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $rep = true;
            foreach($temp['renseignements'] as $renseignement){
                $renseignement_id = $renseignement['renseignement_id'];
                $valeur = isset($renseignement['valeur'])?$renseignement['valeur']:null;
                $commentaire = isset($renseignement['commentaire'])?$renseignement['commentaire']:null;
                $rep = $rep and $this->enregistrerRenseignement($renseignement_id,$valeur,$commentaire,$eleve_id);
            }
            if($rep){
                $this->Flash->success("La fiche a été enregistrée avec succès.");
            }else{
                $this->Flash->error("Il y a eu quelques erreurs dans l'enregistrement de la fiche.");
            }
            $this->redirect(['action'=> 'fiche',$eleve_id]);
        }
        $this->set(compact('eleve','types'));
    }

}