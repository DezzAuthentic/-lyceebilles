<?php
namespace App\Controller\Professorat;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;


class BulletinsController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('prof');
    }

    public function index(){
        $this->loadModel('Groupes');
        $this->loadModel('Periodes');
        $etab = $this->getEtablissement();

        $periodes = $this->Periodes->find('all',[
            'conditions' => ['Periodes.annee_id' => $etab->annee_id, 'Periodes.statut'=>'clôturé']
        ]);

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
        $this->set(compact('groupes','effectifs','periodes'));
    }

    public function periode($periode_id,$affectation_id){
        $this->loadModel('Cours');
        $this->loadModel('Affectations');
        $this->loadModel('Periodes');
        $this->loadModel('PeriodeBulletins');
        $this->loadModel('Presences');

        $etab = $this->getEtablissement();

        $affectation = $this->Affectations->get($affectation_id,['contain'=>['Inscriptions.Eleves','Groupes']]);
        $affectations = $this->Affectations->find('all',[
            'conditions' => ['groupe_id' => $affectation->groupe->id]
        ]);
        $periode = $this->Periodes->get($periode_id);

        $bulletin = $this->PeriodeBulletins->find('all',[
            'contain' => ['PeriodeBulletinLignes.Cours.Matieres'],
            'conditions' => ['PeriodeBulletins.periode_id' => $periode_id, 'PeriodeBulletins.affectation_id' => $affectation_id]
        ])->first();

        $retards = $this->Presences->find('all',[
            'contain' => ['Seances.Cours.Groupes.Promotions'],
            'conditions' => ['Promotions.annee_id'=>$etab->annee_id,'Presences.type'=>'retard','Presences.eleve_id'=>$affectation->eleve_id]
        ]);
        $absences = $this->Presences->find('all',[
            'contain' => ['Seances.Cours.Groupes.Promotions'],
            'conditions' => ['Promotions.annee_id'=>$etab->annee_id,'Presences.type'=>'absence','Presences.eleve_id'=>$affectation->eleve_id]
        ]);
        $affectation->absences = $absences->toArray();
        
        $cours = $this->Cours->find('all',[
            'contain' => ['Matieres','Devoirs.DevoirNotes','Devoirs'=>['conditions'=>['Devoirs.periode_id'=>$periode_id]]],
            'conditions' => ['Cours.groupe_id'=> $affectation->groupe_id]
        ])->toArray();
        //dd($cours->toArray());
        $matieres = array();
        foreach($cours as $c=>$cour){
            $matieres[$c]["nom"] = $cour->matiere->nom;
            $devoirs = $cour->devoirs;
            $nbr = sizeof($devoirs);
            $nbr_1 = intval($nbr/5);
            $nbr_2 = intval(($nbr-$nbr_1)/4);
            $nbr_3 = intval(($nbr-$nbr_1-$nbr_2)/3);
            $nbr_4 = intval(($nbr-$nbr_1-$nbr_2-$nbr_3)/2);
            $nbr_5 = $nbr-$nbr_1-$nbr_2-$nbr_3-$nbr_4;
            $matieres[$c]["nombre"][0]=$nbr_1;
            $matieres[$c]["nombre"][1]=$nbr_2;
            $matieres[$c]["nombre"][2]=$nbr_3;
            $matieres[$c]["nombre"][3]=$nbr_4;
            $matieres[$c]["nombre"][4]=$nbr_5;
            $dev_liste = array();
            //dd("nbr1:".$nbr_1." - nbr2:".$nbr_2." - nbr3:".$nbr_3);
            for($i=0;$i<$nbr_1;$i++){
                $dev_liste[0][$i]=$devoirs[$i];
            }
            
            for($i=0;$i<$nbr_2;$i++){
                $dev_liste[1][$i]=$devoirs[$nbr_1+$i];
            }
            for($i=0;$i<$nbr_3;$i++){
                $dev_liste[2][$i]=$devoirs[$nbr_1+$nbr_2+$i];
            }
            for($i=0;$i<$nbr_4;$i++){
                $dev_liste[3][$i]=$devoirs[$nbr_1+$nbr_2+$nbr_3+$i];
            }
            for($i=0;$i<$nbr_5;$i++){
                $dev_liste[4][$i]=$devoirs[$nbr_1+$nbr_2+$nbr_3+$nbr_4+$i];
            }
            // dd($dev_liste);
            foreach($dev_liste as $d=>$dev){
                $max = null;
                $min = null;
                $note = null;
                $i=0;
                $note_eleve = array();
                foreach($dev as $devoir){
                    foreach($devoir->devoir_notes as $note){
                        if($note->note!=null){
                            if(!isset($note_eleve[$note->eleve_id])){
                                $note_eleve[$note->eleve_id]['somme']=$note->note;
                                $note_eleve[$note->eleve_id]['nombre']=1;
                            }
                            else{
                                $note_eleve[$note->eleve_id]['somme']+=$note->note;
                                $note_eleve[$note->eleve_id]['nombre']++;
                            }
                        }
                    }
                }
                foreach($note_eleve as $k=>$not){
                    $note = $not['somme']/$not['nombre'];
                    $note_eleve[$k]=$note;
                    if($i==0){
                        $max=$note;
                        $min=$note;
                        $i=1;
                    }else{
                        $max = $max>$note?$max:$note;
                        $min = $min<$note?$min:$note;
                    }
                }
                $matieres[$c]['notes'][$d]['eleves'] = $note_eleve; 
                $matieres[$c]['notes'][$d]['max'] = $max; 
                $matieres[$c]['notes'][$d]['min'] = $min; 
            }
        }
        //dd($bulletin);
        $this->set(compact('affectation','affectations','matieres','periode','bulletin','retards','absences'));
    }

    public function classe($id, $periode_id=null, $affectation_id=null){
        $this->loadModel("Groupes");
        $this->loadModel("Periodes");

        $etab = $this->getEtablissement();

        $groupe = $this->Groupes->get($id,[
            "contain" => ['Affectations.Inscriptions.Eleves']
        ]);

        $periodes = $this->Periodes->find('all',[
            'conditions' => ['Periodes.annee_id' => $etab->annee_id , 'Periodes.statut'=>'clôturé']
        ]);

        if($periode_id != null){
            $this->loadModel('Cours');
            $this->loadModel('Affectations');
            $this->loadModel('Periodes');
            $this->loadModel('PeriodeBulletins');
            $this->loadModel('Presences');

            $etab = $this->getEtablissement();

            $affectation = $this->Affectations->get($affectation_id,['contain'=>['Inscriptions.Eleves','Groupes']]);
            $affectations = $this->Affectations->find('all',[
                'conditions' => ['groupe_id' => $affectation->groupe->id]
            ]);
            $periode = $this->Periodes->get($periode_id);

            $bulletin = $this->PeriodeBulletins->find('all',[
                'contain' => ['PeriodeBulletinLignes.Cours.Matieres'],
                'conditions' => ['PeriodeBulletins.periode_id' => $periode_id, 'PeriodeBulletins.affectation_id' => $affectation_id]
            ])->first();

            $retards = $this->Presences->find('all',[
                'contain' => ['Seances.Cours.Groupes.Promotions'],
                'conditions' => ['Promotions.annee_id'=>$etab->annee_id,'Presences.type'=>'retard','Presences.eleve_id'=>$affectation->eleve_id]
            ]);
            $absences = $this->Presences->find('all',[
                'contain' => ['Seances.Cours.Groupes.Promotions'],
                'conditions' => ['Promotions.annee_id'=>$etab->annee_id,'Presences.type'=>'absence','Presences.eleve_id'=>$affectation->eleve_id]
            ]);
            $affectation->absences = $absences->toArray();
            
            $cours = $this->Cours->find('all',[
                'contain' => ['Matieres','Devoirs.DevoirNotes','Devoirs'=>['conditions'=>['Devoirs.periode_id'=>$periode_id]]],
                'conditions' => ['Cours.groupe_id'=> $affectation->groupe_id]
            ])->toArray();
            //dd($cours->toArray());
            $matieres = array();
            foreach($cours as $c=>$cour){
                $matieres[$c]["nom"] = $cour->matiere->nom;
                $devoirs = $cour->devoirs;
                $nbr = sizeof($devoirs);
                $nbr_1 = intval($nbr/5);
                $nbr_2 = intval(($nbr-$nbr_1)/4);
                $nbr_3 = intval(($nbr-$nbr_1-$nbr_2)/3);
                $nbr_4 = intval(($nbr-$nbr_1-$nbr_2-$nbr_3)/2);
                $nbr_5 = $nbr-$nbr_1-$nbr_2-$nbr_3-$nbr_4;
                $matieres[$c]["nombre"][0]=$nbr_1;
                $matieres[$c]["nombre"][1]=$nbr_2;
                $matieres[$c]["nombre"][2]=$nbr_3;
                $matieres[$c]["nombre"][3]=$nbr_4;
                $matieres[$c]["nombre"][4]=$nbr_5;
                $dev_liste = array();
                //dd("nbr1:".$nbr_1." - nbr2:".$nbr_2." - nbr3:".$nbr_3);
                for($i=0;$i<$nbr_1;$i++){
                    $dev_liste[0][$i]=$devoirs[$i];
                }
                
                for($i=0;$i<$nbr_2;$i++){
                    $dev_liste[1][$i]=$devoirs[$nbr_1+$i];
                }
                for($i=0;$i<$nbr_3;$i++){
                    $dev_liste[2][$i]=$devoirs[$nbr_1+$nbr_2+$i];
                }
                for($i=0;$i<$nbr_4;$i++){
                    $dev_liste[3][$i]=$devoirs[$nbr_1+$nbr_2+$nbr_3+$i];
                }
                for($i=0;$i<$nbr_5;$i++){
                    $dev_liste[4][$i]=$devoirs[$nbr_1+$nbr_2+$nbr_3+$nbr_4+$i];
                }
                // dd($dev_liste);
                foreach($dev_liste as $d=>$dev){
                    $max = null;
                    $min = null;
                    $note = null;
                    $i=0;
                    $note_eleve = array();
                    foreach($dev as $devoir){
                        foreach($devoir->devoir_notes as $note){
                            if($note->note!=null){
                                if(!isset($note_eleve[$note->eleve_id])){
                                    $note_eleve[$note->eleve_id]['somme']=$note->note;
                                    $note_eleve[$note->eleve_id]['nombre']=1;
                                }
                                else{
                                    $note_eleve[$note->eleve_id]['somme']+=$note->note;
                                    $note_eleve[$note->eleve_id]['nombre']++;
                                }
                            }
                        }
                    }
                    foreach($note_eleve as $k=>$not){
                        $note = $not['somme']/$not['nombre'];
                        $note_eleve[$k]=$note;
                        if($i==0){
                            $max=$note;
                            $min=$note;
                            $i=1;
                        }else{
                            $max = $max>$note?$max:$note;
                            $min = $min<$note?$min:$note;
                        }
                    }
                    $matieres[$c]['notes'][$d]['eleves'] = $note_eleve; 
                    $matieres[$c]['notes'][$d]['max'] = $max; 
                    $matieres[$c]['notes'][$d]['min'] = $min; 
                }
            }
        
        }

        $this->set(compact('groupe','periodes', 'affectation','affectations','matieres','periode','bulletin','retards','absences'));
    }

    public function appreciations(){
        $etab = $this->getEtablissement();

        $user_id = $this->logUser();
        $this->loadModel("Professeurs");
        $this->loadModel("Cours");

        $prof = $this->Professeurs->find('all',[
            'conditions' => ['Professeurs.user_id'=>$user_id]
        ])->first();

        $cours = $this->Cours->find('all',[
            'contain' => ['Matieres','Professeurs','Groupes.Promotions','Seances.Presences','Edt'],
            'conditions' => ['Promotions.annee_id' => $etab->annee_id, 'Professeurs.id'=>$prof->id]
        ]);
        $this->set(compact('cours'));
    }

    public function appreciationsCours($id){
        $this->loadModel('Cours');
        $this->loadModel('Periodes');
        $etab = $this->getEtablissement();

        $cours = $this->Cours->get($id, [
            'contain' => ['Matieres','Professeurs','Groupes.Affectations.Inscriptions.Eleves',
                "Groupes.Affectations.PeriodeBulletins.Periodes" => [
                    "conditions" => ["Periodes.statut" => 'clôturé']
                ],
                "Groupes.Affectations.PeriodeBulletins.PeriodeBulletinLignes" => [
                    "conditions" => ["PeriodeBulletinLignes.cours_id" => $id]
                ]
            ]
        ]);
        $periodes = $this->Periodes->find('all',[
            'conditions' => ['Periodes.annee_id' => $etab->annee_id, 'Periodes.statut'=>'clôturé']
        ]);
        //debug($cours); 
        // debug($periodes->toArray()); 
        $this->set(compact('periodes','cours'));
    }

    public function enregistrerAppreciations(){
        $this->loadModel('PeriodeBulletinLignes');
        if ($this->request->is('post')) {
            $temp= $this->request->getData();
            $ligne = $this->PeriodeBulletinLignes->get($temp['id']);
            $ligne->appreciation = $temp['appreciation'];
            if ($this->PeriodeBulletinLignes->save($ligne)) {
                $this->Flash->success(__("L'appréciation a été enregistrée avec succès."));
            } else $this->Flash->error(__("La appréciation n'a pu être enregistrée. Merci de réessayer."));
        }
        return $this->redirect($this->referer());
    }
}
