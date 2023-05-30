<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Menu Entity
 *
 * @property int $id
 * @property string $jour
 * @property int $type
 * @property int $plat_id
 * @property int $dessert_id
 * @property int $template_id
 * @property int $status
 *
 * @property \App\Model\Entity\Plat $plat
 * @property \App\Model\Entity\Dessert $dessert
 */
class Menu extends Entity
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
        'jour' => true,
        'type' => true,
        'plat_id' => true,
        'dessert_id' => true,
        'template_id' => true,
        'status' => true,
        'plat' => true,
        'dessert' => true
    ];
}
