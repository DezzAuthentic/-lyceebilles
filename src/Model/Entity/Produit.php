<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Produit Entity
 *
 * @property int $id
 * @property string $libelle
 * @property string $code
 * @property float $prix
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $status
 * @property int $famille_id
 *
 * @property \App\Model\Entity\Famille $famille
 * @property \App\Model\Entity\VLigne[] $v_lignes
 */
class Produit extends Entity
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
        'code' => true,
        'prix' => true,
        'created' => true,
        'modified' => true,
        'status' => true,
        'famille_id' => true,
        'famille' => true,
        'v_lignes' => true
    ];
}
