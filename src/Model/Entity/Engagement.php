<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Engagement Entity
 *
 * @property int $id
 * @property int $frais_id
 * @property int $inscription_id
 * @property int $debut
 * @property int $fin
 * @property float $reduction
 * @property float $parrainage
 *
 * @property \App\Model\Entity\Frai $frai
 * @property \App\Model\Entity\Inscription $inscription
 */
class Engagement extends Entity
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
        'frais_id' => true,
        'inscription_id' => true,
        'debut' => true,
        'fin' => true,
        'reduction' => true,
        'parrainage' => true,
        'frai' => true,
        'inscription' => true
    ];
}
