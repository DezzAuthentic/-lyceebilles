<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RenseignementType Entity
 *
 * @property int $id
 * @property string $libelle
 * @property int $status
 * @property int $etablissement_id
 *
 * @property \App\Model\Entity\Etablissement $etablissement
 * @property \App\Model\Entity\Renseignement[] $renseignements
 */
class RenseignementType extends Entity
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
        'libelle' => true,
        'status' => true,
        'etablissement_id' => true,
        'etablissement' => true,
        'renseignements' => true
    ];
}
