<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AffectationsFixture
 *
 */
class AffectationsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'groupe_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'inscription_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'date' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'fk_affectations_classes1_idx' => ['type' => 'index', 'columns' => ['groupe_id'], 'length' => []],
            'fk_affectations_inscriptions1_idx' => ['type' => 'index', 'columns' => ['inscription_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_affectations_classes1' => ['type' => 'foreign', 'columns' => ['groupe_id'], 'references' => ['groupes', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_affectations_inscriptions1' => ['type' => 'foreign', 'columns' => ['inscription_id'], 'references' => ['inscriptions', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'groupe_id' => 1,
                'inscription_id' => 1,
                'date' => '2018-12-14'
            ],
        ];
        parent::init();
    }
}
