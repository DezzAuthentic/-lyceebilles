<?php
namespace App\Controller\Finance;

use App\Controller\AppController;
use Cake\Event\Event;
use cake\Routing\Router;
use Cake\I18n\Time;

class DashboardController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('finance');
    }

    public function index(){

        $this->loadModel('Factures');
        $this->loadModel('Types');
        $this->loadModel('Promotions');
        $this->loadModel('Mois');
        $this->loadModel('Engagements');

        $etab = $this->getEtablissement();
        $mois = $this->Factures->find("all",[
            'fields' => ['id'=>'Factures.mois_id','a_payer'=>'SUM(Factures.montant)','paye'=>'SUM(Factures.paye)', 'nom'=>'Mois.nom'],
			'contain' => ['Mois','Inscriptions.Promotions'],
			'group' => ['Factures.mois_id'],
			'conditions' => ['Promotions.annee_id' => $etab->annee_id]
        ]);

        $mois_en_cours = $this->getCorrMois(Time::now()->format('m'));
        //dd($mois_en_cours);

        $mois_fin = $this->Mois->get($etab->annee->fin);
        if($mois_en_cours->ordre > $mois_fin->ordre) $mois_en_cours = $mois_fin;

        $types = $this->Types->find('all',[
            'conditions' => ['Types.etablissement_id' => $etab->id, "Types.obligatoire" => 0,'Types.recurrence' => 1]
        ]);
        $promotions = $this->Promotions->find('all',[
            'contain' => ["Inscriptions" => ['conditions' => ['Inscriptions.etat !=' => 'suspendu']]],
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
    
        $this->set(compact('mois','types','promotions','promotions_abandons'));

    }

    public function type($id){
        $this->loadModel('Types');
        $this->loadModel('Promotions');
        $this->loadModel('Engagements');
        $etab = $this->getEtablissement();
        
        $type = $this->Types->get($id,['contain' => ['Frais']]);
        // dd($type);
        $promotions = $this->Promotions->find('all',[
            'conditions' => ['Promotions.annee_id' => $etab->annee_id]
        ])->toArray();
        foreach($promotions as $promotion){
            $frais = $this->Engagements->find('all',[
                'contain' => ['Inscriptions','Frais'],
                'conditions' => [
                    'Inscriptions.etat !=' => 'suspendu',
                    'Inscriptions.promotion_id' => $promotion->id,
                    'Frais.type_id' => $type->id
                ],
                'group' => ['Engagements.frais_id'],
                'fields' => [
                    'frais_id' => 'Engagements.frais_id',
                    'frais_nom' => 'Frais.nom',
                    'nombre' => 'COUNT(Engagements.id)'
                ]
            ]);
            $promotion->frais = $frais->toArray();
            //dd($promotion);
        }
        $this->set(compact('type','promotions'));
    }
}