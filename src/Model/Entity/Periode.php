<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Periode Entity
 *
 * @property int $id
 * @property string $nom
 * @property \Cake\I18n\FrozenDate $debut
 * @property \Cake\I18n\FrozenDate $fin
 * @property int $annee_id
 * @property string $statut
 *
 * @property \App\Model\Entity\Annee $annee
 * @property \App\Model\Entity\PeriodeBulletin[] $periode_bulletins
 */
class Periode extends Entity
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
        'debut' => true,
        'fin' => true,
        'annee_id' => true,
        'statut' => true,
        'annee' => true,
        'periode_bulletins' => true
    ];
}
