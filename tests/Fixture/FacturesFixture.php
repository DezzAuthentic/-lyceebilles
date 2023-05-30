<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FacturesFixture
 *
 */
class FacturesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'montant' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'paye' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'restant' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'mois_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'date' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'inscription_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'details' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'parrainage' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'frais_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'engagement_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_factures_mois1_idx' => ['type' => 'index', 'columns' => ['mois_id'], 'length' => []],
            'fk_factures_inscriptions1_idx' => ['type' => 'index', 'columns' => ['inscription_id'], 'length' => []],
            'fk_factures_frais1_idx' => ['type' => 'index', 'columns' => ['frais_id'], 'length' => []],
            'fk_factures_engagements1_idx' => ['type' => 'index', 'columns' => ['engagement_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_factures_engagements1' => ['type' => 'foreign', 'columns' => ['engagement_id'], 'references' => ['engagements', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_factures_frais1' => ['type' => 'foreign', 'columns' => ['frais_id'], 'references' => ['frais', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_factures_inscriptions1' => ['type' => 'foreign', 'columns' => ['inscription_id'], 'references' => ['inscriptions', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_factures_mois1' => ['type' => 'foreign', 'columns' => ['mois_id'], 'references' => ['mois', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'montant' => 1,
                'paye' => 1,
                'restant' => 1,
                'mois_id' => 1,
                'date' => '2018-12-12 22:39:43',
                'inscription_id' => 1,
                'details' => 'Lorem ipsum dolor sit amet',
                'parrainage' => 1,
                'frais_id' => 1,
                'engagement_id' => 1
            ],
        ];
        parent::init();
    }
}
