<?php
namespace App\Controller\Professorat;

use App\Controller\AppController;
use Cake\Event\Event;
use cake\Routing\Router;

class DashboardController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('prof');
    }

    public function index(){
        return $this->redirect(['controller'=>'Edt',"action"=>"index"]);
    }
}