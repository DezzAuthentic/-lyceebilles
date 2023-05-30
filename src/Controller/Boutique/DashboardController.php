<?php
namespace App\Controller\Boutique;

use App\Controller\AppController;
use Cake\Event\Event;
use cake\Routing\Router;

class DashboardController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('boutique');
    }

    public function index(){
        $this->loadModel('Promotions');
        $this->loadModel('Ventes');

        $etab = $this->getEtablissement();
        $promotions = $this->Promotions->find('all',[
            'contain' => ['Inscriptions','Groupes'],
            'conditions' => ['Promotions.annee_id'=>$etab->annee_id]
        ]);

        $ventes_attente = $this->Ventes->find('all',[
            'contain' => ['VLignes.Produits.Familles', 'Eleves'],
            'conditions' => ['Ventes.etablissement_id' => $etab->id, 'Ventes.status IN'=>[1,2]],
            'order' => ['Ventes.created ASC']
        ]);

        $ventes_nonsoldees = $this->Ventes->find('all',[
            'contain' => ['VLignes.Produits.Familles', 'Eleves'],
            'conditions' => ['Ventes.etablissement_id' => $etab->id, 'Ventes.status'=>4],
            'order' => ['Ventes.created ASC']
        ]);

        $this->set(compact('promotions','ventes_attente','ventes_nonsoldees'));
    }
}