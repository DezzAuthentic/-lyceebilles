<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Etablissement Entity
 *
 * @property int $id
 * @property string $nom
 * @property string $adresse
 * @property string $tel
 * @property string $email
 * @property string $logo
 * @property string $couverture
 * @property int $configuration_id
 * @property int $admin_id
 * @property int $annee_id
 *
 * @property \App\Model\Entity\Configuration $configuration
 * @property \App\Model\Entity\Employe[] $employes
 * @property \App\Model\Entity\Annee[] $annees
 * @property \App\Model\Entity\Elef[] $eleves
 * @property \App\Model\Entity\Matiere[] $matieres
 * @property \App\Model\Entity\Niveaux[] $niveaux
 * @property \App\Model\Entity\Professeur[] $professeurs
 * @property \App\Model\Entity\Salle[] $salles
 * @property \App\Model\Entity\Series[] $series
 * @property \App\Model\Entity\Tuteur[] $tuteurs
 */
class Etablissement extends Entity
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
        'adresse' => true,
        'tel' => true,
        'email' => true,
        'logo' => true,
        'couverture' => true,
        'configuration_id' => true,
        'admin_id' => true,
        'annee_id' => true,
        'configuration' => true,
        'employes' => true,
        'annees' => true,
        'eleves' => true,
        'matieres' => true,
        'niveaux' => true,
        'professeurs' => true,
        'salles' => true,
        'series' => true,
        'tuteurs' => true
    ];
}
