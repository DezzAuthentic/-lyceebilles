<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EdtFixture
 *
 */
class EdtFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'edt';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'jour' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'debut' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'duree' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'salle_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'cours_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_edt_salles1_idx' => ['type' => 'index', 'columns' => ['salle_id'], 'length' => []],
            'fk_edt_cours1_idx' => ['type' => 'index', 'columns' => ['cours_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_edt_cours1' => ['type' => 'foreign', 'columns' => ['cours_id'], 'references' => ['cours', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_edt_salles1' => ['type' => 'foreign', 'columns' => ['salle_id'], 'references' => ['salles', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'jour' => 'Lorem ip',
                'debut' => 1,
                'duree' => 1,
                'salle_id' => 1,
                'cours_id' => 1
            ],
        ];
        parent::init();
    }
}
