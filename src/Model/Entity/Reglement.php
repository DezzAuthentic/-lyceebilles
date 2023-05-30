<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Reglement Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime $date
 * @property int $montant
 * @property string $moyen
 * @property int $facture_id
 * @property int $user_id
 *
 * @property \App\Model\Entity\Facture $facture
 * @property \App\Model\Entity\User $user
 */
class Reglement extends Entity
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
        'date' => true,
        'montant' => true,
        'moyen' => true,
        'facture_id' => true,
        'user_id' => true,
        'facture' => true,
        'user' => true
    ];
}
