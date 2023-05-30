<?php
namespace App\Controller\Secretariat;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Event\Event;

/**
 * Tuteurs Controller
 *
 * @property \App\Model\Table\TuteursTable $Tuteurs
 *
 * @method \App\Model\Entity\Tuteur[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TuteursController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('secretariat');
    }
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->autoRender = false;
        $rep = false;

        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $tuteur = $this->Tuteurs->newEntity();
            $tuteur = $this->Tuteurs->patchEntity($tuteur, $temp);
            if ($this->Tuteurs->save($tuteur)) {
                $rep = $tuteur; 
            }
        }

        echo json_encode($rep);                    
    }

    public function liste(){
    
        $this->loadModel('Tuteurs');
        $etab = $this->getEtablissement();
    
        $tuteurs = $this->Tuteurs->find('all',[
            'contain' => ['Users','Eleves.Inscriptions.Promotions' => ['conditions' => ['Promotions.annee_id' => $etab->annee_id]]],
            'conditions' => ['Tuteurs.etablissement_id'=>$etab->id,'Tuteurs.etat !=' => 0]
        ]);
        
        //dd($tuteurs->toArray());
        $this->set(compact('tuteurs'));
    }

    public function desactiver($id){
        $tuteur = $this->Tuteurs->get($id);
        $tuteur->etat = 0;
        $this->Tuteurs->save($tuteur);
        $this->redirect($this->referer()); 
    }

    public function fiche($id){
        $tuteur = $this->Tuteurs->get($id,[
            'contain' => ['Users','Eleves.Inscriptions.Affectations.Groupes','Eleves.Inscriptions.Promotions.Annees','TuteurSecondaires.Users']
        ]);
        $this->set(compact('tuteur'));
    }

    public function modifier($id){
        $tuteur = $this->Tuteurs->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $temp = $this->request->getData();
            //dd($temp);
            $tuteur = $this->Tuteurs->patchEntity($tuteur, $temp);
            if (!$this->Tuteurs->save($tuteur)) {
                $this->Flash->error(__("La modification n'a pu être effectuée. Merci de réessayer!"));
            }else $this->redirect(['action'=>'fiche',$tuteur->id]);
        }
        $this->set(compact('tuteur'));
    }

    public function editerPhoto(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $id = $temp['id'];
            $image = $temp['image'];
            $extensions = array("jpeg", "jpg", "gif","png");
            $url = $this->definirPj($image,$extensions,'tuteurs',$id);
            if(!$url){  
                $this->Flash->error(__("L'imge n'a pu être modifiée. Merci de réessayer."));
            }else{
                $tuteur = $this->Tuteurs->get($id);
                $tuteur->photo = $url;
                $this->Tuteurs->save($tuteur);
            }
            return $this->redirect($this->referer());
        }
    }

    public function ajouterSecondaire(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $secondaire = $this->Tuteurs->TuteurSecondaires->newEntity();
            $secondaire = $this->Tuteurs->TuteurSecondaires->patchEntity($secondaire, $temp);
            // dd($secondaire);
            if(!$this->Tuteurs->TuteurSecondaires->save($secondaire)){  
                $this->Flash->error(__("Le tuteur n'a pu être enregistré. Merci de réessayer."));
            }
            return $this->redirect($this->referer());
        }
    }

    public function modifierSecondaire(){
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            $secondaire = $this->Tuteurs->TuteurSecondaires->get($temp['id'], ['contain' => ["Users"]]);
            $secondaire->nom = $temp['nom'];
            $secondaire->prenom = $temp['prenom'];
            $secondaire->user->email = $temp['user']['email'];
            if($temp['user']['password'] != '') $secondaire->user->password = $temp['user']['password'];
            //dd($secondaire);
            if(!$this->Tuteurs->TuteurSecondaires->save($secondaire)){  
                $this->Flash->error(__("Le tuteur n'a pu être modifié. Merci de réessayer."));
            }
            return $this->redirect($this->referer());
        }
    }

    public function supprimerSecondaire($id){
        try{
            if ($this->request->is('post')) {
                $secondaire = $this->Tuteurs->TuteurSecondaires->get($id);
                if (!$this->Tuteurs->TuteurSecondaires->delete($secondaire)) {
                    $this->Flash->error(__("La suppression n'a pu être faite. Merci de réessayer."));
                }
            }
        }catch(\Exception $e){
            $this->Flash->error(__("Impossible d'effectuer la suppression!"));
        }
        return $this->redirect($this->referer());
    }
}


