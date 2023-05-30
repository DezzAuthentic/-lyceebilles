<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Employe Entity
 *
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string $telephone
 * @property string $adresse
 * @property string $fonction
 * @property \Cake\I18n\FrozenDate $date_debut
 * @property int $user_id
 * @property string $photo
 * @property int $etablissement_id
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Etablissement $etablissement
 */
class Employe extends Entity
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
        'nom' => true,
        'prenom' => true,
        'telephone' => true,
        'adresse' => true,
        'fonction' => true,
        'date_debut' => true,
        'user_id' => true,
        'photo' => true,
        'etablissement_id' => true,
        'user' => true,
        'etablissement' => true
    ];
}
