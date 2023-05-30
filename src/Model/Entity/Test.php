<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Test Entity
 *
 * @property int $id
 * @property float $note
 * @property string $appreciation
 * @property int $status
 * @property \Cake\I18n\FrozenDate $date
 * @property string $heure
 * @property string $duree
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $promotion_id
 * @property int $eleve_id
 * @property int $matiere_id
 *
 * @property \App\Model\Entity\Promotion $promotion
 * @property \App\Model\Entity\Elef $elef
 * @property \App\Model\Entity\Matiere $matiere
 */
class Test extends Entity
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
        'status' => true,
        'date' => true,
        'heure' => true,
        'duree' => true,
        'created' => true,
        'modified' => true,
        'promotion_id' => true,
        'eleve_id' => true,
        'matiere_id' => true,
        'promotion' => true,
        'elef' => true,
        'matiere' => true
    ];
}
