<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Affectation Entity
 *
 * @property int $id
 * @property int $groupe_id
 * @property int $inscription_id
 * @property \Cake\I18n\FrozenDate $date
 *
 * @property \App\Model\Entity\Groupe $groupe
 * @property \App\Model\Entity\Inscription $inscription
 * @property \App\Model\Entity\PeriodeBulletin[] $periode_bulletins
 */
class Affectation extends Entity
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
        'groupe_id' => true,
        'inscription_id' => true,
        'date' => true,
        'groupe' => true,
        'inscription' => true,
        'periode_bulletins' => true
    ];
}
