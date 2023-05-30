<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Inscription Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenDate $date
 * @property string $etat
 * @property int $eleve_id
 * @property int $promotion_id
 *
 * @property \App\Model\Entity\Elef $elef
 * @property \App\Model\Entity\Promotion $promotion
 * @property \App\Model\Entity\Engagement[] $engagements
 * @property \App\Model\Entity\Affectation[] $affectations
 */
class Inscription extends Entity
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
        'date' => true,
        'etat' => true,
        'eleve_id' => true,
        'promotion_id' => true,
        'elef' => true,
        'promotion' => true,
        'engagements' => true,
        'affectations' => true
    ];
}
