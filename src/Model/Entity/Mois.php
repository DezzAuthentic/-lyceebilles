<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Mois Entity
 *
 * @property int $id
 * @property string $nom
 * @property int $ordre
 * @property string $code
 * @property int $etablissement_id
 *
 * @property \App\Model\Entity\Etablissement $etablissement
 * @property \App\Model\Entity\Engagement[] $engagements
 * @property \App\Model\Entity\Facture[] $factures
 */
class Mois extends Entity
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
        'ordre' => true,
        'code' => true,
        'etablissement_id' => true,
        'etablissement' => true,
        'engagements' => true,
        'factures' => true
    ];
}
