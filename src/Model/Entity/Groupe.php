<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Groupe Entity
 *
 * @property int $id
 * @property string $nom
 * @property string $description
 * @property int $promotion_id
 * @property int $effectif
 * @property int $salle_id
 *
 * @property \App\Model\Entity\Promotion $promotion
 * @property \App\Model\Entity\Salle $salle
 * @property \App\Model\Entity\Affectation[] $affectations
 * @property \App\Model\Entity\Cour[] $cours
 */
class Groupe extends Entity
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
        'description' => true,
        'promotion_id' => true,
        'effectif' => true,
        'salle_id' => true,
        'promotion' => true,
        'salle' => true,
        'affectations' => true,
        'cours' => true
    ];
}
