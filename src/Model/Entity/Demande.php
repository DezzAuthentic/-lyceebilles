<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Demande Entity
 *
 * @property int $id
 * @property string $type
 * @property string $texte
 * @property string $etat
 * @property \Cake\I18n\FrozenDate $date
 * @property int $tuteur_id
 *
 * @property \App\Model\Entity\Tuteur $tuteur
 */
class Demande extends Entity
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
        'type' => true,
        'texte' => true,
        'etat' => true,
        'date' => true,
        'tuteur_id' => true,
        'tuteur' => true
    ];
}
