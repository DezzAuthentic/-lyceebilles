<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RenseignementValeur Entity
 *
 * @property int $id
 * @property int $valeur
 * @property string $commentaire
 * @property int $renseignement_id
 * @property int $eleve_id
 *
 * @property \App\Model\Entity\Renseignement $renseignement
 * @property \App\Model\Entity\Elef $elef
 */
class RenseignementValeur extends Entity
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
        'valeur' => true,
        'commentaire' => true,
        'renseignement_id' => true,
        'eleve_id' => true,
        'renseignement' => true,
        'elef' => true
    ];
}
