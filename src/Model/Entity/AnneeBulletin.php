<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AnneeBulletin Entity
 *
 * @property int $id
 * @property int $affectation_id
 * @property float $moyenne
 * @property string $appreciation
 *
 * @property \App\Model\Entity\Affectation $affectation
 */
class AnneeBulletin extends Entity
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
        'affectation_id' => true,
        'moyenne' => true,
        'appreciation' => true,
        'affectation' => true
    ];
}
