<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Salle Entity
 *
 * @property int $id
 * @property string $nom
 * @property string $pavillon
 * @property string $etage
 * @property int $capacite
 * @property int $etablissement_id
 *
 * @property \App\Model\Entity\Edt[] $edt
 * @property \App\Model\Entity\Groupe[] $groupes
 * @property \App\Model\Entity\Seance[] $seances
 */
class Salle extends Entity
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
        'pavillon' => true,
        'etage' => true,
        'capacite' => true,
        'etablissement_id' => true,
        'edt' => true,
        'groupes' => true,
        'seances' => true
    ];
}
