<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Famille Entity
 *
 * @property int $id
 * @property string $libelle
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $status
 * @property int $etablissement_id
 *
 * @property \App\Model\Entity\Etablissement $etablissement
 * @property \App\Model\Entity\Produit[] $produits
 */
class Famille extends Entity
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
        'libelle' => true,
        'created' => true,
        'modified' => true,
        'status' => true,
        'etablissement_id' => true,
        'etablissement' => true,
        'produits' => true
    ];
}
