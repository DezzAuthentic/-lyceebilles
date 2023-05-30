<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TuteurSecondaire Entity
 *
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property int $tuteur_id
 * @property int $user_id
 *
 * @property \App\Model\Entity\Tuteur $tuteur
 * @property \App\Model\Entity\User $user
 */
class TuteurSecondaire extends Entity
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
        'prenom' => true,
        'tuteur_id' => true,
        'user_id' => true,
        'tuteur' => true,
        'user' => true
    ];
}
