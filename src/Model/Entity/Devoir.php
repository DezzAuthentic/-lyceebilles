<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Devoir Entity
 *
 * @property int $id
 * @property string $nom
 * @property \Cake\I18n\FrozenTime $date
 * @property int $duree
 * @property string $description
 * @property int $cours_id
 * @property int $periode_id
 *
 * @property \App\Model\Entity\Cour $cour
 * @property \App\Model\Entity\DevoirNote[] $devoir_notes
 */
class Devoir extends Entity
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
        'date' => true,
        'duree' => true,
        'description' => true,
        'cours_id' => true,
        'periode_id' => true,
        'cour' => true,
        'devoir_notes' => true
    ];
}
