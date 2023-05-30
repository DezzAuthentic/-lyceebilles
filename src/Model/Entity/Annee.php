<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Annee Entity
 *
 * @property int $id
 * @property string $nom
 * @property \Cake\I18n\FrozenDate $professeur_ouverture
 * @property \Cake\I18n\FrozenDate $administration_ouverture
 * @property \Cake\I18n\FrozenDate $inscription_ouverture
 * @property \Cake\I18n\FrozenDate $classe_ouverture
 * @property int $debut
 * @property int $fin
 * @property int $etablissement_id
 *
 * @property \App\Model\Entity\Etablissement[] $etablissements
 * @property \App\Model\Entity\Periode[] $periodes
 * @property \App\Model\Entity\Promotion[] $promotions
 */
class Annee extends Entity
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
        'professeur_ouverture' => true,
        'administration_ouverture' => true,
        'inscription_ouverture' => true,
        'classe_ouverture' => true,
        'debut' => true,
        'fin' => true,
        'etablissement_id' => true,
        'etablissements' => true,
        'periodes' => true,
        'promotions' => true
    ];
}
