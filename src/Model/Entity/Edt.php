<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Edt Entity
 *
 * @property int $id
 * @property string $jour
 * @property int $debut
 * @property int $duree
 * @property int $salle_id
 * @property int $cours_id
 *
 * @property \App\Model\Entity\Salle $salle
 * @property \App\Model\Entity\Cour $cour
 */
class Edt extends Entity
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
        'jour' => true,
        'debut' => true,
        'duree' => true,
        'salle_id' => true,
        'cours_id' => true,
        'salle' => true,
        'cour' => true
    ];
}
