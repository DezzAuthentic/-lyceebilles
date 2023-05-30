<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CoursFixture
 *
 */
class CoursFixture extends TestFixture
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
        'matiere_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'professeur_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'volume' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'volume_effectue' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'contenu' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null],
        'pj' => ['type' => 'string', 'length' => 225, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'type' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'fk_cours_classes1_idx' => ['type' => 'index', 'columns' => ['groupe_id'], 'length' => []],
            'fk_cours_matieres1_idx' => ['type' => 'index', 'columns' => ['matiere_id'], 'length' => []],
            'fk_cours_professeurs1_idx' => ['type' => 'index', 'columns' => ['professeur_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_cours_classes1' => ['type' => 'foreign', 'columns' => ['groupe_id'], 'references' => ['groupes', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_cours_matieres1' => ['type' => 'foreign', 'columns' => ['matiere_id'], 'references' => ['matieres', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_cours_professeurs1' => ['type' => 'foreign', 'columns' => ['professeur_id'], 'references' => ['professeurs', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'matiere_id' => 1,
                'professeur_id' => 1,
                'volume' => 1,
                'volume_effectue' => 1,
                'contenu' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'pj' => 'Lorem ipsum dolor sit amet',
                'type' => 'Lorem ipsum dolor sit amet'
            ],
        ];
        parent::init();
    }
}
