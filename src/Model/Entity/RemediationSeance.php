<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RemediationSeance Entity
 *
 * @property int $id
 * @property int $type
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $status
 * @property \Cake\I18n\FrozenDate $date
 * @property float $debut
 * @property float $duree
 * @property string $contenu
 * @property int $remediation_id
 * @property float $note
 *
 * @property \App\Model\Entity\Remediation $remediation
 */
class RemediationSeance extends Entity
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
        'type' => true,
        'created' => true,
        'modified' => true,
        'status' => true,
        'date' => true,
        'debut' => true,
        'duree' => true,
        'contenu' => true,
        'remediation_id' => true,
        'note' => true,
        'remediation' => true
    ];
}
