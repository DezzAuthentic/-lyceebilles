<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Ouvrage Entity
 *
 * @property int $id
 * @property string $titre
 * @property string $resume
 * @property int $quantite
 * @property string $type
 * @property string $pj
 * @property int $en_pret
 * @property string $rangement
 * @property int $ouvrage_categorie_id
 *
 * @property \App\Model\Entity\OuvrageCategory $ouvrage_category
 * @property \App\Model\Entity\Emprunt[] $emprunts
 */
class Ouvrage extends Entity
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
        'titre' => true,
        'resume' => true,
        'quantite' => true,
        'type' => true,
        'pj' => true,
        'en_pret' => true,
        'rangement' => true,
        'ouvrage_categorie_id' => true,
        'ouvrage_category' => true,
        'emprunts' => true
    ];
}
