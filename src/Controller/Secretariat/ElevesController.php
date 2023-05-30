<?php
namespace App\Controller\Secretariat;

use App\Controller\AppController;
use Cake\Event\Event;
use cake\Routing\Router;
/**
 * Eleves Controller
 *
 * @property \App\Model\Table\ElevesTable $Eleves
 *
 * @method \App\Model\Entity\Elef[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ElevesController extends AppController
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
    

    public function getEleve($tuteur_id){
        $this->autoRender = false;
        $etab = $this->getEtablissement();

        $eleves = $this->Eleves->find('all',[
            'contain' => ['Inscriptions.Promotions.Niveaux'=>[
                 'conditions' => ['Promotions.annee_id'=>$etab->annee_id,'Niveaux.etablissement_id'=>$etab->id]
            ]],
            'conditions' => ['Eleves.tuteur_id' => $tuteur_id,'Eleves.etat !=' => 0]
        ]);
        $eleves = $eleves->toArray();
        foreach($eleves as $i => $eleve) if (!empty($eleve->inscriptions)) unset($eleves[$i]);

        echo json_encode($eleves);
    }

    public function add()
    {
        $this->autoRender = false;
        $rep = false;

        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $eleve = $this->Eleves->newEntity();
            $eleve = $this->Eleves->patchEntity($eleve, $temp);
            if ($this->Eleves->save($eleve)) {
                $rep = $eleve; 
                $this->genererMatricule($eleve->id);
                $this->Eleves->save($eleve);
            }
        }
        echo json_encode($rep);                    
    }

    public function genererMatricule($eleve_id){
        $this->loadModel("Eleves");
        $eleve = $this->Eleves->get($eleve_id);
        $eleve->matricule = 'B'.Date('y').'-T'.$eleve->tuteur_id.'-'.$eleve->id;
        $this->Eleves->save($eleve);
    }

    public function listeGlobale(){
        $etab = $this->getEtablissement();

        $eleves = $this->Etablissements->Eleves->find('all',[
            'contain' => ['Users','Inscriptions.Affectations.Groupes', 'Inscriptions.Promotions' =>[
                    'conditions' =>['Promotions.annee_id'=>$etab->annee_id]
                ]
            ],
            'conditions' => ['Eleves.etablissement_id'=>$etab->id,'Eleves.etat !=' => 0]
        ]);
        $this->set(compact('eleves'));
    }

    public function listeAnneeEnCours(){
        $etab = $this->getEtablissement();

        $eleves = $this->Etablissements->Eleves->find('all',[
            'contain' => ['Users','Inscriptions.Affectations.Groupes', 'Inscriptions.Promotions' =>[
                    'conditions' =>['Promotions.annee_id'=>$etab->annee_id]
                ]
            ],
            'conditions' => ['Eleves.etablissement_id'=>$etab->id,'Eleves.etat !=' => 0]
        ]);
        $this->set(compact('eleves'));
    }

    function classes(){
        $this->loadModel('Groupes');
        $etab = $this->getEtablissement();

        $groupes = $this->Groupes->find('all',[
            'contain' => ['Promotions.Niveaux','Affectations','Promotions.Inscriptions'],
            'conditions' => ['Promotions.annee_id'=> $etab->annee_id],
            'order' => ['Niveaux.ordre' => 'ASC']
        ]);
        $groupes = $groupes->toArray();
        $effectifs = Array();
        $promo_id = null;
        foreach($groupes as $groupe){
            if($promo_id!=$groupe->promotion->id){
                if(!array_key_exists($groupe->promotion->niveau_id,$effectifs)) $effectifs[$groupe->promotion->niveau_id] = 0;
                $effectifs[$groupe->promotion->niveau_id] += sizeof($groupe->promotion->inscriptions);
                $promo_id = $groupe->promotion->id;
            }
        }
        //dd($effectifs);
        $this->set(compact('groupes','effectifs'));
    }

    public function classe($id){
        $etab = $this->getEtablissement();
        $this->loadModel("Groupes");

        $groupe = $this->Groupes->get($id,[
            "contain" => ['Affectations.Inscriptions.Eleves' => [
                'conditions' => ['Eleves.etat !=' => 0]
            ]]
        ]);

        $this->set(compact('groupe','periodes'));

        $this->set(compact('groupe'));
    }

    public function desactiver($id){
        $eleve = $this->Eleves->get($id);
        $eleve->etat = 0;
        $this->Eleves->save($eleve);
        $this->redirect($this->referer()); 
    }

    public function fiche($id){
        $eleve = $this->Eleves->get($id,[
            'contain' => ['Tuteurs.Users','Inscriptions.Affectations.Groupes','Inscriptions.Promotions.Annees']
        ]);
        $this->set(compact('eleve'));
    }

    public function modifier($id){
        $eleve = $this->Eleves->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $temp = $this->request->getData();
            //dd($temp);
            $eleve = $this->Eleves->patchEntity($eleve, $temp);
            if (!$this->Eleves->save($eleve)) {
                $this->Flash->error(__("La modification n'a pu être effectuée. Merci de réessayer!"));
            }else $this->redirect(['action'=>'fiche',$eleve->id]);
        }
        $this->set(compact('eleve'));
    }

    public function editerPhoto(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $id = $temp['id'];
            $image = $temp['image'];
            $extensions = array("jpeg", "jpg", "gif","png");
            $url = $this->definirPj($image,$extensions,'eleves',$id);
            if(!$url){  
                $this->Flash->error(__("L'imge n'a pu être modifiée. Merci de réessayer."));
            }else{
                $eleve = $this->Eleves->get($id);
                $eleve->photo = $url;
                $this->Eleves->save($eleve);
            }
            return $this->redirect($this->referer());
        }
    }
}
