<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EngagementsFixture
 *
 */
class EngagementsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'frais_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'inscription_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'debut' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'fin' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'reduction' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'parrainage' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'fk_engagements_frais1_idx' => ['type' => 'index', 'columns' => ['frais_id'], 'length' => []],
            'fk_engagements_mois1_idx' => ['type' => 'index', 'columns' => ['debut'], 'length' => []],
            'fk_engagements_inscriptions1_idx' => ['type' => 'index', 'columns' => ['inscription_id'], 'length' => []],
            'fk_engagements_mois2_idx' => ['type' => 'index', 'columns' => ['fin'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_engagements_frais1' => ['type' => 'foreign', 'columns' => ['frais_id'], 'references' => ['frais', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_engagements_inscriptions1' => ['type' => 'foreign', 'columns' => ['inscription_id'], 'references' => ['inscriptions', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_engagements_mois1' => ['type' => 'foreign', 'columns' => ['debut'], 'references' => ['mois', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_engagements_mois2' => ['type' => 'foreign', 'columns' => ['fin'], 'references' => ['mois', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'frais_id' => 1,
                'inscription_id' => 1,
                'debut' => 1,
                'fin' => 1,
                'reduction' => 1,
                'parrainage' => 1
            ],
        ];
        parent::init();
    }
}
