<?php
namespace App\Controller\Academie;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Promotions Controller
 *
 * @property \App\Model\Table\PromotionsTable $Promotions
 *
 * @method \App\Model\Entity\Promotion[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PromotionsController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('academie');
    }

    public function index()
    {
        $etab = $this->getEtablissement();

        $promotions = $this->Promotions->find("all",[
            'contain' => ['Inscriptions','Groupes.Affectations','Niveaux'], 
            'conditions' => ['Promotions.annee_id'=>$etab->annee_id],
            'order' => ["Niveaux.ordre" => "ASC"]
        ]);

        $this->set(compact('promotions'));
    }

    public function gestion($id){

        $promotion = $this->Promotions->get($id,[
            'contain' => ['Groupes.Affectations','Inscriptions.Eleves']
        ]);

        $inscrits_non_affectes = $this->nonAffectes($id);

        $groupes_list = $this->Promotions->Groupes->find('list',[
            'conditions' => ['Groupes.promotion_id'=> $id]
        ]);

        $this->set(compact('promotion','inscrits_non_affectes','groupes_list'));

    }

    public function nonAffectes($promotion_id){

        $this->loadModel('Affectations');
        $this->loadModel('Inscriptions');
        
        $affectes = $this->Affectations->find('all',[
            'contain' => ['Inscriptions'],
            'conditions' => ['Inscriptions.promotion_id' => $promotion_id]
        ])->extract('inscription_id');

        if($affectes->count() == 0){
            $inscrits_non_affectes = $this->Inscriptions->find('all',[
                'contain' => ['Eleves'],
                'conditions' => ['Inscriptions.promotion_id' => $promotion_id]
            ]);
        }else{
            $inscrits_non_affectes = $this->Inscriptions->find('all',[
                'contain' => ['Eleves'],
                'conditions' => ['Inscriptions.promotion_id' => $promotion_id, 'Inscriptions.id NOT IN'=>$affectes->toArray()]
            ]);
        }

        return $inscrits_non_affectes;
    }

    public function transfert(){
        $etab = $this->getEtablissement();
        $this->loadModel('Affectations');
        $this->loadModel('Inscriptions');
        $this->loadModel('Groupes');

        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $affectation = $this->Affectations->get($temp['affectation_id']);
            $affectation->groupe_id = $temp['classe_id'];
            //modification de la promotion
            $inscription = $this->Inscriptions->get($affectation->inscription_id);
            $inscription->promotion_id = $temp['promotion_id'];
            
            //
            if ($this->Affectations->save($affectation) and $this->Inscriptions->save($inscription)) {
                $this->Flash->success("Le transfert a été effectué avec succès.");
            }else{
                $this->Flash->error("Une erreur est survenue. Merci de réessayer.");
            }
        }

        $affectations = $this->Affectations->find('all',[
            'contain' => ['Groupes','Inscriptions.Eleves','Inscriptions.Promotions'],
            'conditions' => ['Promotions.annee_id'=>$etab->annee_id]
        ]);

        $this->set(compact('affectations'));
    }
    
}
