<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PeriodeBulletinsFixture
 *
 */
class PeriodeBulletinsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'periode_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'affectation_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'moyenne' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'appreciation' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'moyenne_classe' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'meilleure_moyenne' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'fk_semestre_bulletins_periodes1_idx' => ['type' => 'index', 'columns' => ['periode_id'], 'length' => []],
            'fk_semestre_bulletins_affectations1_idx' => ['type' => 'index', 'columns' => ['affectation_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_semestre_bulletins_affectations1' => ['type' => 'foreign', 'columns' => ['affectation_id'], 'references' => ['affectations', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_semestre_bulletins_periodes1' => ['type' => 'foreign', 'columns' => ['periode_id'], 'references' => ['periodes', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'periode_id' => 1,
                'affectation_id' => 1,
                'moyenne' => 1,
                'appreciation' => 'Lorem ipsum dolor sit amet',
                'moyenne_classe' => 1,
                'meilleure_moyenne' => 1
            ],
        ];
        parent::init();
    }
}
