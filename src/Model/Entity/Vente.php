<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Vente Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $status
 * @property int $etablissement_id
 * @property int $eleve_id
 * @property float $total
 * @property float $paye
 * @property float $restant
 *
 * @property \App\Model\Entity\Etablissement $etablissement
 * @property \App\Model\Entity\Elef $elef
 * @property \App\Model\Entity\VLigne[] $v_lignes
 */
class Vente extends Entity
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
        'etablissement_id' => true,
        'eleve_id' => true,
        'total' => true,
        'paye' => true,
        'restant' => true,
        'etablissement' => true,
        'elef' => true,
        'v_lignes' => true
    ];
}
