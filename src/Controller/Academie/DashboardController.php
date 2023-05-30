<?php
namespace App\Controller\Academie;

use App\Controller\AppController;
use Cake\Event\Event;
use cake\Routing\Router;
use Cake\I18n\Time;

class DashboardController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('academie');
    }

    public function index(){
        $this->loadModel('Promotions');
        $this->loadModel('Types');
        $this->loadModel('Engagements');
        $this->loadModel('Mois');
        $this->loadModel('Inscriptions');
        
        $etab = $this->getEtablissement();

        $mois_en_cours = $this->getCorrMois(Time::now()->format('m'));
        //dd($mois_en_cours);

        $mois_fin = $this->Mois->get($etab->annee->fin);
        if($mois_en_cours->ordre > $mois_fin->ordre) $mois_en_cours = $mois_fin;

        $types = $this->Types->find('all',[
            'conditions' => ['Types.etablissement_id' => $etab->id, "Types.obligatoire" => 0,'Types.recurrence' => 1]
        ]);
        $promotions = $this->Promotions->find('all',[
            'contain' => ['Groupes',"Inscriptions" => ['conditions' => ['Inscriptions.etat !=' => 'suspendu']]],
            'conditions' => ['Promotions.annee_id' => $etab->annee_id]
        ])->toArray();
        $promotions_abandons = $this->Promotions->find('all',[
            'contain' => ["Inscriptions" => ['conditions' => ['Inscriptions.etat' => 'suspendu']]],
            'conditions' => ['Promotions.annee_id' => $etab->annee_id]
        ])->toArray();

        foreach($promotions as $promotion){
            foreach($promotion->inscriptions as $inscription){
                $engagements = $this->Engagements->find('all', [
                    'contain' => ['Debut','Fin','Frais.Types'=>['conditions'=>["Types.obligatoire" => 0,'Types.recurrence' => 1]]],
                    'conditions' => ['Engagements.inscription_id' => $inscription->id]
                ]);
                $inscription->engagements = Array();
                foreach($engagements as $engagement){
                    //dd($engagement->mois_fin->ordre);
                    if($engagement->mois_fin->ordre >= $mois_en_cours->ordre) $inscription->engagements[] = $engagement;
                }

            }
        }

        // Total des inscriptions de l'année en cours
        $inscriptions = $this->Inscriptions->find('all',[
            "contain" => ["Promotions"],
            "conditions" => ['Promotions.annee_id' => $etab->annee_id]
        ])->count();
        $affectations = $this->Inscriptions->Affectations->find('all',[
            'contain' => ['Inscriptions.Promotions'],
            "conditions" => ['Promotions.annee_id' => $etab->annee_id]
        ])->count();

        $en_attente = $inscriptions - $affectations;

        //dd($en_attente);
        $this->set(compact('types','promotions','promotions_abandons','en_attente'));

    }
    
}