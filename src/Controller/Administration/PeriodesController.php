<?php
namespace App\Controller\Administration;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Periodes Controller
 *
 * @property \App\Model\Table\PeriodesTable $Periodes
 *
 * @method \App\Model\Entity\Periode[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PeriodesController extends AppController
{
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('admin');
    }

    public function configuration(){
        $etab = $this->getEtablissement();
        $periodes = $this->Periodes->find('all',[
            'conditions' => ['Periodes.annee_id' => $etab->annee_id]
        ]);
        

        $this->set(compact('periodes'));
    }

    public function initialiser(){
        $etab = $this->getEtablissement();

        if($this->request->is('post')){
            $temp = $this->request->getData();
            $nombre = $temp['nombre'];

            if($nombre==2) $nom = 'Semestre';
            elseif($nombre==3) $nom = 'Trimestre';
            elseif($nombre==4 or $nombre==5) $nom = 'Bimestre';
            else $nom = 'Période';

            $periodes = $this->Periodes->find('all',[
                'conditions' => ['Periodes.annee_id' => $etab->annee_id]
            ]);
            $nombre_per = $periodes->count();
            //debug($nombre);
            //dd($nombre_per);
            if($nombre_per<=$nombre){
                $i=1;
                foreach($periodes as $periode){
                    $periode->nom = $nom." ".$i;
                    $this->Periodes->save($periode);
                    $i++;
                }
                for($i=$nombre_per+1;$i<=$nombre;$i++){
                    $periode = $this->Periodes->newEntity();
                    $periode->nom = $nom." ".$i;
                    $periode->annee_id = $etab->annee_id;
                    $this->Periodes->save($periode);
                }
            }else{
                $periodes_suppr = $this->Periodes->find('all',[
                    'conditions' => ['Periodes.annee_id' => $etab->annee_id],
                    'order' => ['Periodes.id' => 'DESC']
                ]);
                $i=1;
                foreach($periodes_suppr as $per){
                    try{
                        $this->Periodes->delete($per);
                        if(($nombre_per - $nombre) == $i) break;
                        $i++;
                    }catch(\Exception $e){}
                }
                $i=1;
                $periodes = $this->Periodes->find('all',[
                    'conditions' => ['Periodes.annee_id' => $etab->annee_id]
                ]);
                foreach($periodes as $periode){
                    $periode->nom = $nom." ".$i;
                    $this->Periodes->save($periode);
                    $i++;
                }
            }
        }
        return $this->redirect($this->referer());
    }

}
