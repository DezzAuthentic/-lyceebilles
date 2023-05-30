<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TestsFixture
 *
 */
class TestsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'note' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'appreciation' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'status' => ['type' => 'tinyinteger', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'date' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'heure' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'duree' => ['type' => 'string', 'length' => 8, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'promotion_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'eleve_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'matiere_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_tests_promotions2_idx' => ['type' => 'index', 'columns' => ['promotion_id'], 'length' => []],
            'fk_tests_eleves2_idx' => ['type' => 'index', 'columns' => ['eleve_id'], 'length' => []],
            'fk_tests_matieres2_idx' => ['type' => 'index', 'columns' => ['matiere_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_tests_eleves2' => ['type' => 'foreign', 'columns' => ['eleve_id'], 'references' => ['eleves', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_tests_matieres2' => ['type' => 'foreign', 'columns' => ['matiere_id'], 'references' => ['matieres', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_tests_promotions2' => ['type' => 'foreign', 'columns' => ['promotion_id'], 'references' => ['promotions', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'note' => 1,
                'appreciation' => 'Lorem ipsum dolor sit amet',
                'status' => 1,
                'date' => '2019-09-16',
                'heure' => 'Lorem ip',
                'duree' => 'Lorem ',
                'created' => '2019-09-16 18:29:44',
                'modified' => '2019-09-16 18:29:44',
                'promotion_id' => 1,
                'eleve_id' => 1,
                'matiere_id' => 1
            ],
        ];
        parent::init();
    }
}
