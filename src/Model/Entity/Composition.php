<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Composition Entity
 *
 * @property int $id
 * @property int $cours_id
 * @property \Cake\I18n\FrozenTime $date
 * @property int $duree
 * @property string $description
 *
 * @property \App\Model\Entity\Cour $cour
 */
class Composition extends Entity
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
        'cours_id' => true,
        'date' => true,
        'duree' => true,
        'description' => true,
        'cour' => true
    ];
}
