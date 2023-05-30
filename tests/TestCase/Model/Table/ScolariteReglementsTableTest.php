<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ScolariteReglementsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ScolariteReglementsTable Test Case
 */
class ScolariteReglementsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ScolariteReglementsTable
     */
    public $ScolariteReglements;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.scolarite_reglements',
        'app.scolarites',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ScolariteReglements') ? [] : ['className' => ScolariteReglementsTable::class];
        $this->ScolariteReglements = TableRegistry::getTableLocator()->get('ScolariteReglements', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ScolariteReglements);

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
