<?php
namespace App\Controller\Finance;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Menus Controller
 *
 * @property \App\Model\Table\MenusTable $Menus
 *
 * @method \App\Model\Entity\Menu[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MenusController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('finance');
    }

    public function init(){
        $this->Menus->init();
        dd('ok');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $etab = $this->getEtablissement();
        $temp_menus = $this->Menus->find('all',[
            'contain' => ['Plats','Desserts'],
            'conditions' => ["OR" => ['Plats.etablissement_id' => $etab->id, 'Desserts.etablissement_id'=>$etab->id],"Menus.status"=>1]
        ]);
        $menus = [];
        foreach($temp_menus as $menu){
            $menus[$menu->jour][$menu->type]['plat'] = $menu->plat?$menu->plat->nom:null;
            $menus[$menu->jour][$menu->type]['dessert'] = $menu->dessert?$menu->dessert->nom:null;
        }
        $plats = $this->Menus->Plats->find('list',[
            'conditions' => ['Plats.etablissement_id' => $etab->id]
        ]);
        $desserts = $this->Menus->Desserts->find('list',[
            'conditions' => ['Desserts.etablissement_id' => $etab->id]
        ]);
        //dd($menus);
        $this->set(compact('menus','plats','desserts'));
    }
}
