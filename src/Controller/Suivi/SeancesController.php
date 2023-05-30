<?php
namespace App\Controller\Suivi;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Seances Controller
 *
 * @property \App\Model\Table\SeancesTable $Seances
 *
 * @method \App\Model\Entity\Seance[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SeancesController extends AppController
{
    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('suivi');
    }

    /**
     * View method
     *
     * @param string|null $id Seance id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function fiche($id = null)
    {
        $seance = $this->Seances->get($id, [
            'contain' => ['Cours.Matieres','Cours.Professeurs','Cours.Groupes.Affectations.Inscriptions.Eleves','Exercices','Presences']
        ]);

        $this->set('seance', $seance);
    }

    
}
