<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Etablissements Controller
 *
 * @property \App\Model\Table\EtablissementsTable $Etablissements
 *
 * @method \App\Model\Entity\Etablissement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 *
 */

 /*
Liste des fonctions
inscrire : ajouter un éablissement et un user en tant qu'admin
 */
class EtablissementsController extends AppController
{
    public function inscrire(){
        $etab = $this->Etablissements->newEntity();
        $admin = $this->Etablissements->Employes->newEntity();
        $user = $this->Etablissements->Employes->Users->newEntity();
        $config = $this->Etablissements->Configurations->newEntity();
        /***initialisation des config***/
        $config->professeur_acces = 0;
        $config->tuteur_acces = 0;
        $config->eleve_acces = 0;
        $config->notification_email = 0;
        $config->notification_sms = 0;
        /*******************************/
        if ($this->request->is('post')) {
            $temp = $this->request->getData();
            dd($temp);
            $temp_etab = $temp['etab'];
            $temp_user = $temp['admin'];
            $user = $this->Etablissements->Employes->Users->patchEntity($user, $temp_user);
            $etab = $this->Etablissements->patchEntity($etab, $temp_etab);
            if ($this->Etablissements->Employes->Users->save($user)) {
                $admin->user_id = $user->id;
                if ($this->Etablissements->Employes->save($admin)) {
                    $etab->admin_id = $admin->id;
                    if($this->Etablissements->Configurations->save($config)){
                        $etab->configuration_id = $config->id;
                        if ($this->Etablissements->save($etab)) {
                            $admin->etablissement_id = $etab->id;
                            $this->Etablissements->Employes->save($admin);
                            return $this->redirect(['controller'=>'Pages','action' => 'display','connexion']);
                        }else {
                            $this->Etablissements->Employes->delete($admin);
                            $this->Etablissements->Employes->Users->delete($user);
                            $this->Etablissements->Configurations->delete($config);
                            debug('probleme etab');
                            $this->Flash->error(__("L'inscription n'a pu être faite. Merci de réessayer."));
                        }
                    }else{
                        $this->Etablissements->Employes->delete($admin);
                        $this->Etablissements->Employes->Users->delete($user);
                        $this->Flash->error(__("L'inscription n'a pu être faite. Merci de réessayer."));
                        debug('probleme config');
                    }
                }else{
                    $this->Etablissements->Employes->Users->delete($user);
                    $this->Flash->error(__("L'inscription n'a pu être faite. Merci de réessayer."));
                    debug('probleme admin');
                }
            }
            debug('probleme user');
            $this->Flash->error(__("L'inscription n'a pu être faite. Merci de réessayer."));
            return $this->redirect(['controller'=>'Pages','action' => 'display','inscrire']);
        }
    }
}
