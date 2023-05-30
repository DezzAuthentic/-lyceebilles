<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Series Entity
 *
 * @property int $id
 * @property string $nom
 * @property string $description
 * @property int $etablissement_id
 */
class Series extends Entity
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
        'etablissement_id' => true
    ];
}
