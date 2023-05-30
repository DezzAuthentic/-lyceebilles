<?php
namespace App\Controller\Academie;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Event\Event;
use Cake\I18n\Time;

/**
 * Professeurs Controller
 *
 * @property \App\Model\Table\TestsTable $Professeurs
 *
 * @method \App\Model\Entity\Professeur[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TestsController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('academie');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $etab = $this->getEtablissement();

        $tests = $this->Tests->find('all',[
            'contain' => ['Eleves',"Promotions",'Matieres'],
            'conditions' => ['Promotions.annee_id' => $etab->annee_id]
        ]);

        $this->set(compact('tests'));
    }

    
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function inscrire()
    {
        $etab = $this->getEtablissement();

        $matieres = $this->Tests->Matieres->find('all',[
            'conditions' => ['Matieres.etablissement_id' => $etab->id]
        ]);

        $tests = $this->Tests->find('all',[
            'contain' => ["Promotions"],
            'conditions' => ['Promotions.annee_id' => $etab->annee_id]
        ])->extract('eleve_id');
        //dd($tests->toArray());
        $en_tests = $tests->toArray();
        $en_tests[] = 0;
        $eleves = $this->Tests->Eleves->find('all',[
            'conditions' => ['Eleves.etablissement_id' =>$etab->id, "Eleves.id NOT IN" => $en_tests]
        ]);
        $promotions = $this->Tests->Promotions->find('all',[
            'conditions' => ['Promotions.annee_id' =>$etab->annee_id]
        ]);

        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            //dd($temp);
            $eleve_id = $temp['eleve_id'];
            $promotion_id = $temp['promotion_id'];
            $lignes = $temp['lignes'];
            $ok=1;
            foreach($lignes as $ligne){
                $test = $this->Tests->newEntity();
                $test->created = Time::now();
                $test->status = 1;
                $test->promotion_id = $promotion_id;
                $test->eleve_id = $eleve_id;
                $test->matiere_id = $ligne['matiere_id'];
                $test->date = $ligne['date'];
                $test->heure = $ligne['heure'];
                $test->duree = $ligne['duree'];
                if(!$this->Tests->save($test)) $ok = $ok and 0;
            }
            if($ok) $this->Flash->success("Tests enregistrés avec succès.");
            else $this->Flash->error("Erreurs d'enregistrement. Merci de réessayer.");
            return $this->redirect(['action' => "index"]);
            //dd($temp);
        }
        $this->set(compact('eleves','matieres','promotions'));
    }
    
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

            if ($this->Tests->deleteAll(["eleve_id" => $id])) {
                $this->Flash->success(__("Les tests de l'élève ont été bien supprimés."));
            } else {
                $this->Flash->error(__("Les test de l'élève n'ont pu être supprimés. Merci de réessayer."));
            }
        }catch(\Exception $e){
            $this->Flash->error(__("Impossible d'effectuer la suppression!"));
        }
        return $this->redirect($this->referer());
    }

    public function fiche($eleve_id){
        $etab = $this->getEtablissement();
        $eleve = $this->Tests->Eleves->get($eleve_id);
        $tests = $this->Tests->find("all",[
            'contain' => ['Promotions','Matieres'],
            'conditions' => ['Promotions.annee_id' => $etab->annee_id,"Tests.eleve_id" => $eleve_id]
        ]);
        foreach($tests as $test){
            $promotion = $test->promotion;
            break;
        }

        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            //dd($temp);
            $lignes = $temp['tests'];
            $ok=1;
            foreach($lignes as $ligne){
                $test = $this->Tests->get($ligne['id']);
                $test->note = $ligne['note'];
                $test->appreciation = $ligne['appreciation'];
                if(!$this->Tests->save($test)) $ok = $ok and 0;
            }
            if($ok) $this->Flash->success("Tests enregistrés avec succès.");
            else $this->Flash->error("Erreurs d'enregistrement. Merci de réessayer.");
            return $this->redirect(['action' => "fiche",$eleve_id]);
            //dd($temp);
        }

        $this->set(compact('eleve','promotion','tests'));
    }

    public function modifier($eleve_id){
        $etab = $this->getEtablissement();
        $eleve = $this->Tests->Eleves->get($eleve_id);
        $tests = $this->Tests->find("all",[
            'contain' => ['Promotions','Matieres'],
            'conditions' => ['Promotions.annee_id' => $etab->annee_id,"Tests.eleve_id" => $eleve_id]
        ]);
        foreach($tests as $test){
            $promotion = $test->promotion;
            break;
        }

        $matieres = $this->Tests->Matieres->find('all',[
            'conditions' => ['Matieres.etablissement_id' => $etab->id]
        ]);

        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            //dd($temp);
            $promotion_id = $promotion->id;
            $lignes = $temp['lignes'];
            $ok=1;
            $this->Tests->deleteAll(["eleve_id"=>$eleve_id]);
            foreach($lignes as $ligne){
                $test = $this->Tests->newEntity();
                $test->created = Time::now();
                $test->status = 1;
                $test->promotion_id = $promotion_id;
                $test->eleve_id = $eleve_id;
                $test->matiere_id = $ligne['matiere_id'];
                $test->date = $ligne['date'];
                $test->heure = $ligne['heure'];
                $test->duree = $ligne['duree'];
                if(!$this->Tests->save($test)) $ok = $ok and 0;
            }
            if($ok) $this->Flash->success("Tests modifiés avec succès.");
            else $this->Flash->error("Erreurs lors de la modification. Merci de réessayer.");
            return $this->redirect(['action' => "fiche",$eleve_id]);
            //dd($temp);
        }

        $this->set(compact('eleve','promotion','tests','matieres'));

    }
}
