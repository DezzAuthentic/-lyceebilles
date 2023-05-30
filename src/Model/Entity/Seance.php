<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Seance Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenDate $date
 * @property int $debut
 * @property int $duree
 * @property string $contenu
 * @property string $etat
 * @property int $cours_id
 * @property int $salle_id
 *
 * @property \App\Model\Entity\Cour $cour
 * @property \App\Model\Entity\Salle $salle
 * @property \App\Model\Entity\Exercice[] $exercices
 * @property \App\Model\Entity\Presence[] $presences
 */
class Seance extends Entity
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
        'date' => true,
        'debut' => true,
        'duree' => true,
        'contenu' => true,
        'etat' => true,
        'cours_id' => true,
        'salle_id' => true,
        'cour' => true,
        'salle' => true,
        'exercices' => true,
        'presences' => true
    ];
}
