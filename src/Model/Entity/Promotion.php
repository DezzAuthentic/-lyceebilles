<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Promotion Entity
 *
 * @property int $id
 * @property string $nom
 * @property int $annee_id
 * @property int $niveau_id
 * @property int $serie_id
 * @property int $montant_inscription
 * @property float $moyenne_test
 * @property int $scolarite
 * @property int $effectif
 *
 * @property \App\Model\Entity\Annee $annee
 * @property \App\Model\Entity\Niveaux $niveaux
 * @property \App\Model\Entity\Series $series
 * @property \App\Model\Entity\Coefficient[] $coefficients
 * @property \App\Model\Entity\Groupe[] $groupes
 * @property \App\Model\Entity\InscriptionFrai[] $inscription_frais
 * @property \App\Model\Entity\Inscription[] $inscriptions
 * @property \App\Model\Entity\Test[] $tests
 */
class Promotion extends Entity
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
        'annee_id' => true,
        'niveau_id' => true,
        'serie_id' => true,
        'montant_inscription' => true,
        'moyenne_test' => true,
        'scolarite' => true,
        'effectif' => true,
        'annee' => true,
        'niveaux' => true,
        'series' => true,
        'coefficients' => true,
        'groupes' => true,
        'inscription_frais' => true,
        'inscriptions' => true,
        'tests' => true
    ];
}
