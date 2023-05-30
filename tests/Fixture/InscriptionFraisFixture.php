<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * InscriptionFraisFixture
 *
 */
class InscriptionFraisFixture extends TestFixture
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
        'frais_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'promotion_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_inscription_frais_frais1_idx' => ['type' => 'index', 'columns' => ['frais_id'], 'length' => []],
            'fk_inscription_frais_promotions1_idx' => ['type' => 'index', 'columns' => ['promotion_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_inscription_frais_frais1' => ['type' => 'foreign', 'columns' => ['frais_id'], 'references' => ['frais', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_inscription_frais_promotions1' => ['type' => 'foreign', 'columns' => ['promotion_id'], 'references' => ['promotions', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'frais_id' => 1,
                'promotion_id' => 1
            ],
        ];
        parent::init();
    }
}
