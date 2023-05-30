<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Facture Entity
 *
 * @property int $id
 * @property int $montant
 * @property int $paye
 * @property int $restant
 * @property int $mois_id
 * @property \Cake\I18n\FrozenTime $date
 * @property int $inscription_id
 * @property string $details
 * @property int $parrainage
 * @property int $frais_id
 * @property int $engagement_id
 *
 * @property \App\Model\Entity\Mois $mois
 * @property \App\Model\Entity\Inscription $inscription
 * @property \App\Model\Entity\Frai $frai
 * @property \App\Model\Entity\Engagement $engagement
 * @property \App\Model\Entity\Reglement[] $reglements
 */
class Facture extends Entity
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
        'montant' => true,
        'paye' => true,
        'restant' => true,
        'mois_id' => true,
        'date' => true,
        'inscription_id' => true,
        'details' => true,
        'parrainage' => true,
        'frais_id' => true,
        'engagement_id' => true,
        'mois' => true,
        'inscription' => true,
        'frai' => true,
        'engagement' => true,
        'reglements' => true
    ];
}
