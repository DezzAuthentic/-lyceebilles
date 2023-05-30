<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PeriodeBulletin Entity
 *
 * @property int $id
 * @property int $periode_id
 * @property int $affectation_id
 * @property float $moyenne
 * @property string $appreciation
 * @property float $moyenne_classe
 * @property float $meilleure_moyenne
 *
 * @property \App\Model\Entity\Periode $periode
 * @property \App\Model\Entity\Affectation $affectation
 * @property \App\Model\Entity\PeriodeBulletinLigne[] $periode_bulletin_lignes
 */
class PeriodeBulletin extends Entity
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
        'periode_id' => true,
        'affectation_id' => true,
        'moyenne' => true,
        'appreciation' => true,
        'moyenne_classe' => true,
        'meilleure_moyenne' => true,
        'periode' => true,
        'affectation' => true,
        'periode_bulletin_lignes' => true
    ];
}
