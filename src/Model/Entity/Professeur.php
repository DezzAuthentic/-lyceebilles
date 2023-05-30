<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Professeur Entity
 *
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string $adresse
 * @property string $telephone
 * @property \Cake\I18n\FrozenDate $date_naissance
 * @property \Cake\I18n\FrozenDate $date_debut
 * @property string $genre
 * @property int $user_id
 * @property int $etat
 * @property string $photo
 * @property int $etablissement_id
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Cour[] $cours
 * @property \App\Model\Entity\Enseignee[] $enseignees
 */
class Professeur extends Entity
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
        'adresse' => true,
        'telephone' => true,
        'date_naissance' => true,
        'date_debut' => true,
        'genre' => true,
        'user_id' => true,
        'etat' => true,
        'photo' => true,
        'etablissement_id' => true,
        'user' => true,
        'cours' => true,
        'enseignees' => true
    ];
}
