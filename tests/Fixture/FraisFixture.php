<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FraisFixture
 *
 */
class FraisFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'nom' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'montant' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'type_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'niveau_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'serie_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_frais_types1_idx' => ['type' => 'index', 'columns' => ['type_id'], 'length' => []],
            'fk_frais_niveaux1_idx' => ['type' => 'index', 'columns' => ['niveau_id'], 'length' => []],
            'fk_frais_series1_idx' => ['type' => 'index', 'columns' => ['serie_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_frais_niveaux1' => ['type' => 'foreign', 'columns' => ['niveau_id'], 'references' => ['niveaux', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_frais_series1' => ['type' => 'foreign', 'columns' => ['serie_id'], 'references' => ['series', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_frais_types1' => ['type' => 'foreign', 'columns' => ['type_id'], 'references' => ['types', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'montant' => 1,
                'type_id' => 1,
                'niveau_id' => 1,
                'serie_id' => 1
            ],
        ];
        parent::init();
    }
}
