<?php
namespace App\Controller\Boutique;

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
        $this->viewBuilder()->setLayout('boutique');
    }

    /*public function init(){
        $this->Menus->init();
        $this->redirect($this->referer());
    }*/

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
            'conditions' => ["OR" => ['Plats.etablissement_id' => $etab->id, 'Desserts.etablissement_id'=>$etab->id]]
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

    /*public function liste(){
        $etab = $this->getEtablissement();
        $plats = $this->Menus->Plats->find('all',[
            'conditions' => ['Plats.etablissement_id' => $etab->id]
        ]);
        $desserts = $this->Menus->Desserts->find('all',[
            'conditions' => ['Desserts.etablissement_id' => $etab->id]
        ]);
        $this->set(compact('plats','desserts'));
    }
    
    public function editer(){
        if ($this->request->is(['patch', 'post', 'put'])) {
            $temp = $this->request->getData();
            //dd($temp);

            $menu = $this->Menus->find('all',[
                "conditions" => ['Menus.jour' => $temp['jour'],'Menus.type'=>$temp['type']]
            ])->first();
 
            if(!$menu) $menu = $this->Menus->newEntity();
            $menu->plat_id = $temp['plat_id']?$temp['plat_id']:null;
            $menu->dessert_id = $temp['dessert_id']?$temp['dessert_id']:null;
            if (!$this->Menus->save($menu)) {
                $this->Flash->error(__("La modification n'a pu être effectuée. Merci de réessayer!"));
            }
        }
        $this->redirect($this->referer());
    }*/

    
}
