<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Exercice Entity
 *
 * @property int $id
 * @property string $titre
 * @property string $contenu
 * @property \Cake\I18n\FrozenTime $date
 * @property \Cake\I18n\FrozenTime $a_rendre
 * @property string $pj
 * @property int $seance_id
 *
 * @property \App\Model\Entity\Seance $seance
 */
class Exercice extends Entity
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
        'titre' => true,
        'contenu' => true,
        'date' => true,
        'a_rendre' => true,
        'pj' => true,
        'seance_id' => true,
        'seance' => true
    ];
}
