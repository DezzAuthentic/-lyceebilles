<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Frai Entity
 *
 * @property int $id
 * @property string $nom
 * @property int $montant
 * @property int $type_id
 * @property int $niveau_id
 * @property int $serie_id
 *
 * @property \App\Model\Entity\Type $type
 * @property \App\Model\Entity\Niveaux $niveaux
 * @property \App\Model\Entity\Series $series
 */
class Frai extends Entity
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
        'montant' => true,
        'type_id' => true,
        'niveau_id' => true,
        'serie_id' => true,
        'type' => true,
        'niveaux' => true,
        'series' => true
    ];
}
