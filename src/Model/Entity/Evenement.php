<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Evenement Entity
 *
 * @property int $id
 * @property string $titre
 * @property string $type
 * @property \Cake\I18n\FrozenDate $date
 * @property string $debut
 * @property string $fin
 * @property \Cake\I18n\FrozenDate $date_fin
 * @property string $couleur
 */
class Evenement extends Entity
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
        'titre' => true,
        'type' => true,
        'date' => true,
        'debut' => true,
        'fin' => true,
        'date_fin' => true,
        'couleur' => true
    ];
}
