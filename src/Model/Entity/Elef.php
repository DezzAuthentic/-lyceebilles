<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Elef Entity
 *
 * @property int $id
 * @property string $matricule
 * @property string $nom
 * @property string $prenom
 * @property string $genre
 * @property \Cake\I18n\FrozenDate $date_naissance
 * @property string $lieu_naissance
 * @property string $telephone
 * @property string $adresse
 * @property int $tuteur_id
 * @property int $user_id
 * @property int $pays_naissance
 * @property int $nationalite
 * @property string $Religion
 * @property int $cours_religion
 * @property string $photo
 * @property int $etablissement_id
 * @property string $pere
 * @property string $mere
 * @property int $etat
 *
 * @property \App\Model\Entity\Tuteur $tuteur
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Etablissement $etablissement
 * @property \App\Model\Entity\Inscription[] $inscriptions
 */
class Elef extends Entity
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
        'matricule' => true,
        'nom' => true,
        'prenom' => true,
        'genre' => true,
        'date_naissance' => true,
        'lieu_naissance' => true,
        'telephone' => true,
        'adresse' => true,
        'tuteur_id' => true,
        'user_id' => true,
        'pays_naissance' => true,
        'nationalite' => true,
        'Religion' => true,
        'cours_religion' => true,
        'photo' => true,
        'etablissement_id' => true,
        'pere' => true,
        'mere' => true,
        'etat' => true,
        'tuteur' => true,
        'user' => true,
        'etablissement' => true,
        'inscriptions' => true
    ];
}
