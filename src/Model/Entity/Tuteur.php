<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tuteur Entity
 *
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string $telephone
 * @property string $adresse
 * @property string $entreprise
 * @property string $fonction
 * @property \Cake\I18n\FrozenDate $date_naissance
 * @property int $user_id
 * @property int $nationalite
 * @property string $situation_matrimoniale
 * @property int $etat
 * @property string $photo
 * @property int $etablissement_id
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Demande[] $demandes
 * @property \App\Model\Entity\Elef[] $eleves
 */
class Tuteur extends Entity
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
        'telephone' => true,
        'adresse' => true,
        'entreprise' => true,
        'fonction' => true,
        'date_naissance' => true,
        'user_id' => true,
        'nationalite' => true,
        'situation_matrimoniale' => true,
        'etat' => true,
        'photo' => true,
        'etablissement_id' => true,
        'user' => true,
        'demandes' => true,
        'eleves' => true
    ];
    protected function _getNomComplet()
    {
        return
            $this->_properties['prenom'] .
            ' ' .
            $this->_properties['nom'];

    }
}
