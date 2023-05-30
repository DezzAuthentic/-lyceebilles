<?php
namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $profil
 * @property \Cake\I18n\FrozenTime $creatime
 * @property int $etat
 *
 * @property \App\Model\Entity\Elef[] $eleves
 * @property \App\Model\Entity\Employe[] $employes
 * @property \App\Model\Entity\Emprunt[] $emprunts
 * @property \App\Model\Entity\InscriptionReglement[] $inscription_reglements
 * @property \App\Model\Entity\Professeur[] $professeurs
 * @property \App\Model\Entity\ScolariteReglement[] $scolarite_reglements
 * @property \App\Model\Entity\Tuteur[] $tuteurs
 */
class User extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'email' => true,
        'password' => true,
        'profil' => true,
        'creatime' => true,
        'etat' => true,
        'eleves' => true,
        'employes' => true,
        'emprunts' => true,
        'inscription_reglements' => true,
        'professeurs' => true,
        'scolarite_reglements' => true,
        'tuteurs' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
          return (new DefaultPasswordHasher)->hash($password);
        }
    }
}
