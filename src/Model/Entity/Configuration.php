<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Configuration Entity
 *
 * @property int $id
 * @property int $professeur_acces
 * @property int $eleve_acces
 * @property int $tuteur_acces
 * @property int $notification_email
 * @property int $notification_sms
 *
 * @property \App\Model\Entity\Etablissement[] $etablissements
 */
class Configuration extends Entity
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
        'professeur_acces' => true,
        'eleve_acces' => true,
        'tuteur_acces' => true,
        'notification_email' => true,
        'notification_sms' => true,
        'etablissements' => true
    ];
}
