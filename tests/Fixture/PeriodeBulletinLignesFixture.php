<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PeriodeBulletinLignesFixture
 *
 */
class PeriodeBulletinLignesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'periode_bulletin_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'cours_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'note' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'composition_note' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'coef' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'appreciation' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'moyenne_classe' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'meilleure_moyenne' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'fk_semestre_bulletin_lignes_semestre_bulletins1_idx' => ['type' => 'index', 'columns' => ['periode_bulletin_id'], 'length' => []],
            'fk_semestre_bulletin_lignes_cours1_idx' => ['type' => 'index', 'columns' => ['cours_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_semestre_bulletin_lignes_cours1' => ['type' => 'foreign', 'columns' => ['cours_id'], 'references' => ['cours', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_semestre_bulletin_lignes_semestre_bulletins1' => ['type' => 'foreign', 'columns' => ['periode_bulletin_id'], 'references' => ['periode_bulletins', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'periode_bulletin_id' => 1,
                'cours_id' => 1,
                'note' => 1,
                'composition_note' => 1,
                'coef' => 1,
                'appreciation' => 'Lorem ipsum dolor sit amet',
                'moyenne_classe' => 1,
                'meilleure_moyenne' => 1
            ],
        ];
        parent::init();
    }
}
