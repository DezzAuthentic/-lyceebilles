<?php
namespace App\Controller\Academie;

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
        $this->viewBuilder()->setLayout('academie');
    }

    public function index(){
        $etab = $this->getEtablissement();
        $periodes = $this->Periodes->find('all',[
            'conditions' => ['Periodes.annee_id' => $etab->annee_id]
        ]);
        

        $this->set(compact('periodes'));
    }

    public function cloturer($id){
        $this->loadModel('PeriodeBulletins');
        $etab = $this->getEtablissement();
        
        $periode = $this->Periodes->get($id);
        $periode->statut = 'clôturé';
        if($this->Periodes->save($periode)){
            $this->PeriodeBulletins->calculerBulletins($etab->id,$periode->id);
        };
        $this->redirect($this->referer());
    }

    public function ouvrir($id){
        $periode = $this->Periodes->get($id);
        $periode->statut = 'actif';
        $this->Periodes->save($periode);
        $this->redirect($this->referer());
    }
}
