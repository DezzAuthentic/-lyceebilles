<?php
namespace App\Controller\Secretariat;

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
        $this->viewBuilder()->setLayout('secretariat');
    }

    public function init(){
        $this->Menus->init();
        $this->redirect($this->referer());
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $etab = $this->getEtablissement();

        //************** Modèle 1 *****************//
        $temp_menus = $this->Menus->find('all',[
            'contain' => ['Plats','Desserts'],
            'conditions' => ["OR" => ['Plats.etablissement_id' => $etab->id, 'Desserts.etablissement_id'=>$etab->id],  'Menus.template_id' => 1]
        ]);
        $menus = [];
        foreach($temp_menus as $menu){
            $menus[$menu->jour][$menu->type]['plat'] = $menu->plat?$menu->plat->nom:null;
            $menus[$menu->jour][$menu->type]['dessert'] = $menu->dessert?$menu->dessert->nom:null;
            $menus[$menu->jour][$menu->type]['status'] = $menu->status;
        }
        //******************************************//

        //************** Modèle 2 *****************//
        $temp_menus2 = $this->Menus->find('all',[
            'contain' => ['Plats','Desserts'],
            'conditions' => ["OR" => ['Plats.etablissement_id' => $etab->id, 'Desserts.etablissement_id'=>$etab->id],  'Menus.template_id' => 2 ]
        ]);
        $menus2 = [];
        foreach($temp_menus2 as $menu){
            $menus2[$menu->jour][$menu->type]['plat'] = $menu->plat?$menu->plat->nom:null;
            $menus2[$menu->jour][$menu->type]['dessert'] = $menu->dessert?$menu->dessert->nom:null;
            $menus2[$menu->jour][$menu->type]['status'] = $menu->status;
        }
        //******************************************//


        $plats = $this->Menus->Plats->find('list',[
            'conditions' => ['Plats.etablissement_id' => $etab->id]
        ]);
        $desserts = $this->Menus->Desserts->find('list',[
            'conditions' => ['Desserts.etablissement_id' => $etab->id]
        ]);
        //dd($menus);
        $this->set(compact('menus','menus2','plats','desserts'));
    }

    public function liste(){
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
                "conditions" => ['Menus.jour' => $temp['jour'],'Menus.type'=>$temp['type'],"Menus.template_id" => $temp["template_id"]]
            ])->first();
 
            if(!$menu) $menu = $this->Menus->newEntity();
            $menu->plat_id = $temp['plat_id']?$temp['plat_id']:null;
            $menu->dessert_id = $temp['dessert_id']?$temp['dessert_id']:null;
            $menu->template_id = $temp['template_id'];
            if (!$this->Menus->save($menu)) {
                $this->Flash->error(__("La modification n'a pu être effectuée. Merci de réessayer!"));
            }
        }
        $this->redirect($this->referer());
    }

    public function choisirModele($id){
        $menus = $this->Menus->find("all");
        //dd($menus);
        foreach($menus as $menu){
            if ($menu->template_id == $id) $menu->status = 1;
            else $menu->status = 0;
            $this->Menus->save($menu);
        }
        //$this->Menus->updateAll(["Menus.status"=>0],[]);
        //$this->Menus->updateAll(["Menus.status"=>1],["Menus.template_id"=>$id]);
        return $this->redirect($this->referer());
    }

    
}
