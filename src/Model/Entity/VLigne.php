<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VLigne Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $status
 * @property float $prix
 * @property float $quantite
 * @property int $produit_id
 * @property int $vente_id
 *
 * @property \App\Model\Entity\Produit $produit
 * @property \App\Model\Entity\Vente $vente
 */
class VLigne extends Entity
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
        'created' => true,
        'modified' => true,
        'status' => true,
        'prix' => true,
        'quantite' => true,
        'produit_id' => true,
        'vente_id' => true,
        'produit' => true,
        'vente' => true
    ];
}
