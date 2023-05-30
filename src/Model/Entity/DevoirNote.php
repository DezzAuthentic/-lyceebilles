<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DevoirNote Entity
 *
 * @property int $id
 * @property float $note
 * @property string $appreciation
 * @property int $devoir_id
 * @property int $eleve_id
 *
 * @property \App\Model\Entity\Devoir $devoir
 * @property \App\Model\Entity\Elef $elef
 */
class DevoirNote extends Entity
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
        'note' => true,
        'appreciation' => true,
        'devoir_id' => true,
        'eleve_id' => true,
        'devoir' => true,
        'elef' => true
    ];
}
