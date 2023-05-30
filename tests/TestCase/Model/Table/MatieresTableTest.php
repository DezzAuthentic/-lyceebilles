<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MatieresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MatieresTable Test Case
 */
class MatieresTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MatieresTable
     */
    public $Matieres;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.matieres',
        'app.cours',
        'app.enseignees',
        'app.tests'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Matieres') ? [] : ['className' => MatieresTable::class];
        $this->Matieres = TableRegistry::getTableLocator()->get('Matieres', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Matieres);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
