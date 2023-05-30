<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PeriodeBulletinLigne Entity
 *
 * @property int $id
 * @property int $periode_bulletin_id
 * @property int $cours_id
 * @property float $note
 * @property float $composition_note
 * @property int $coef
 * @property string $appreciation
 * @property float $moyenne_classe
 * @property float $meilleure_moyenne
 *
 * @property \App\Model\Entity\PeriodeBulletin $periode_bulletin
 * @property \App\Model\Entity\Cour $cour
 */
class PeriodeBulletinLigne extends Entity
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
        'periode_bulletin_id' => true,
        'cours_id' => true,
        'note' => true,
        'composition_note' => true,
        'coef' => true,
        'appreciation' => true,
        'moyenne_classe' => true,
        'meilleure_moyenne' => true,
        'periode_bulletin' => true,
        'cour' => true
    ];
}
