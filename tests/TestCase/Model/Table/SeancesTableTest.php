<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SeancesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SeancesTable Test Case
 */
class SeancesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SeancesTable
     */
    public $Seances;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.seances',
        'app.cours',
        'app.salles',
        'app.exercices',
        'app.presences'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Seances') ? [] : ['className' => SeancesTable::class];
        $this->Seances = TableRegistry::getTableLocator()->get('Seances', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Seances);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
