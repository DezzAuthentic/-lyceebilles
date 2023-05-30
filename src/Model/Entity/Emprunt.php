<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Emprunt Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenDate $date_emprunt
 * @property \Cake\I18n\FrozenDate $date_retour
 * @property string $etat
 * @property string $commentaires
 * @property int $user_id
 * @property int $ouvrage_id
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Ouvrage $ouvrage
 */
class Emprunt extends Entity
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
        'date_emprunt' => true,
        'date_retour' => true,
        'etat' => true,
        'commentaires' => true,
        'user_id' => true,
        'ouvrage_id' => true,
        'user' => true,
        'ouvrage' => true
    ];
}
