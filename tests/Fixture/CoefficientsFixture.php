<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CoefficientsFixture
 *
 */
class CoefficientsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'matiere_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'niveau_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'serie_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'coef' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => '1', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_coefficients_niveaux1_idx' => ['type' => 'index', 'columns' => ['niveau_id'], 'length' => []],
            'fk_coefficients_series1_idx' => ['type' => 'index', 'columns' => ['serie_id'], 'length' => []],
            'fk_coefficients_matieres1_idx' => ['type' => 'index', 'columns' => ['matiere_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_coefficients_matieres1' => ['type' => 'foreign', 'columns' => ['matiere_id'], 'references' => ['matieres', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_coefficients_niveaux1' => ['type' => 'foreign', 'columns' => ['niveau_id'], 'references' => ['niveaux', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_coefficients_series1' => ['type' => 'foreign', 'columns' => ['serie_id'], 'references' => ['series', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'matiere_id' => 1,
                'niveau_id' => 1,
                'serie_id' => 1,
                'coef' => 1
            ],
        ];
        parent::init();
    }
}
