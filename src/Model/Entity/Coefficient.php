<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Coefficient Entity
 *
 * @property int $id
 * @property int $matiere_id
 * @property int $niveau_id
 * @property int $serie_id
 * @property int $coef
 *
 * @property \App\Model\Entity\Promotion $promotion
 * @property \App\Model\Entity\Niveaux $niveaux
 * @property \App\Model\Entity\Series $series
 */
class Coefficient extends Entity
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
        'matiere_id' => true,
        'niveau_id' => true,
        'serie_id' => true,
        'coef' => true,
        'promotion' => true,
        'niveaux' => true,
        'series' => true
    ];
}
