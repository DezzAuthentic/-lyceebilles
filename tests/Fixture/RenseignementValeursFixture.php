<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RenseignementValeursFixture
 *
 */
class RenseignementValeursFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'valeur' => ['type' => 'tinyinteger', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'commentaire' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'renseignement_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'eleve_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_renseignement_valeurs_renseignements1_idx' => ['type' => 'index', 'columns' => ['renseignement_id'], 'length' => []],
            'fk_renseignement_valeurs_eleves1_idx' => ['type' => 'index', 'columns' => ['eleve_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_renseignement_valeurs_eleves1' => ['type' => 'foreign', 'columns' => ['eleve_id'], 'references' => ['eleves', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_renseignement_valeurs_renseignements1' => ['type' => 'foreign', 'columns' => ['renseignement_id'], 'references' => ['renseignements', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'valeur' => 1,
                'commentaire' => 'Lorem ipsum dolor sit amet',
                'renseignement_id' => 1,
                'eleve_id' => 1
            ],
        ];
        parent::init();
    }
}
