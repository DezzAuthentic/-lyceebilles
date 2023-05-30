<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PromotionsFixture
 *
 */
class PromotionsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'nom' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'annee_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'niveau_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'serie_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'montant_inscription' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'moyenne_test' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'scolarite' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'effectif' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_promotions_annees_idx' => ['type' => 'index', 'columns' => ['annee_id'], 'length' => []],
            'fk_promotions_niveaux1_idx' => ['type' => 'index', 'columns' => ['niveau_id'], 'length' => []],
            'fk_promotions_series1_idx' => ['type' => 'index', 'columns' => ['serie_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_promotions_annees' => ['type' => 'foreign', 'columns' => ['annee_id'], 'references' => ['annees', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_promotions_niveaux1' => ['type' => 'foreign', 'columns' => ['niveau_id'], 'references' => ['niveaux', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_promotions_series1' => ['type' => 'foreign', 'columns' => ['serie_id'], 'references' => ['series', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'nom' => 'Lorem ipsum dolor sit amet',
                'annee_id' => 1,
                'niveau_id' => 1,
                'serie_id' => 1,
                'montant_inscription' => 1,
                'moyenne_test' => 1,
                'scolarite' => 1,
                'effectif' => 1
            ],
        ];
        parent::init();
    }
}
