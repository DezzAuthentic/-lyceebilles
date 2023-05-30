<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EnseigneesFixture
 *
 */
class EnseigneesFixture extends TestFixture
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
        'professeur_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'nom' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'fk_enseignees_matieres1_idx' => ['type' => 'index', 'columns' => ['matiere_id'], 'length' => []],
            'fk_enseignees_professeurs1_idx' => ['type' => 'index', 'columns' => ['professeur_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_enseignees_matieres1' => ['type' => 'foreign', 'columns' => ['matiere_id'], 'references' => ['matieres', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_enseignees_professeurs1' => ['type' => 'foreign', 'columns' => ['professeur_id'], 'references' => ['professeurs', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'professeur_id' => 1,
                'nom' => 'Lorem ipsum dolor sit amet'
            ],
        ];
        parent::init();
    }
}
