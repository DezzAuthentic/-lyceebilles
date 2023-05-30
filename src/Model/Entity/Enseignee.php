<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Enseignee Entity
 *
 * @property int $id
 * @property int $matiere_id
 * @property int $professeur_id
 * @property string $nom
 *
 * @property \App\Model\Entity\Matiere $matiere
 * @property \App\Model\Entity\Professeur $professeur
 */
class Enseignee extends Entity
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
        'matiere_id' => true,
        'professeur_id' => true,
        'nom' => true,
        'matiere' => true,
        'professeur' => true
    ];
}
