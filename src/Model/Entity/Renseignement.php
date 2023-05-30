<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Renseignement Entity
 *
 * @property int $id
 * @property string $libelle
 * @property int $status
 * @property int $renseignement_type_id
 *
 * @property \App\Model\Entity\RenseignementType $renseignement_type
 * @property \App\Model\Entity\RenseignementValeur[] $renseignement_valeurs
 */
class Renseignement extends Entity
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
        'renseignement_type_id' => true,
        'renseignement_type' => true,
        'renseignement_valeurs' => true
    ];
}
