<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Remediation Entity
 *
 * @property int $id
 * @property string $objet
 * @property string $description
 * @property int $status
 * @property int $professeur_id
 * @property int $matiere_id
 * @property int $inscription_id
 *
 * @property \App\Model\Entity\Professeur $professeur
 * @property \App\Model\Entity\Matiere $matiere
 * @property \App\Model\Entity\Inscription $inscription
 * @property \App\Model\Entity\RemediationSeance[] $remediation_seances
 */
class Remediation extends Entity
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
        'objet' => true,
        'description' => true,
        'status' => true,
        'professeur_id' => true,
        'matiere_id' => true,
        'inscription_id' => true,
        'professeur' => true,
        'matiere' => true,
        'inscription' => true,
        'remediation_seances' => true
    ];
}
