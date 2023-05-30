<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Presence Entity
 *
 * @property int $id
 * @property int $seance_id
 * @property int $eleve_id
 * @property string $type
 * @property string $motif
 * @property string $justifie
 *
 * @property \App\Model\Entity\Seance $seance
 * @property \App\Model\Entity\Elef $elef
 */
class Presence extends Entity
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
        'seance_id' => true,
        'eleve_id' => true,
        'type' => true,
        'motif' => true,
        'justifie' => true,
        'seance' => true,
        'elef' => true
    ];
}
