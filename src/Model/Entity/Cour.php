<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Cour Entity
 *
 * @property int $id
 * @property int $groupe_id
 * @property int $matiere_id
 * @property int $professeur_id
 * @property int $volume
 * @property int $volume_effectue
 * @property string $contenu
 * @property string $pj
 * @property string $type
 *
 * @property \App\Model\Entity\Groupe $groupe
 * @property \App\Model\Entity\Matiere $matiere
 * @property \App\Model\Entity\Professeur $professeur
 */
class Cour extends Entity
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
        'groupe_id' => true,
        'matiere_id' => true,
        'professeur_id' => true,
        'volume' => true,
        'volume_effectue' => true,
        'contenu' => true,
        'pj' => true,
        'type' => true,
        'groupe' => true,
        'matiere' => true,
        'professeur' => true
    ];
}
