<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PeriodesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PeriodesTable Test Case
 */
class PeriodesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PeriodesTable
     */
    public $Periodes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.periodes',
        'app.annees',
        'app.periode_bulletins'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Periodes') ? [] : ['className' => PeriodesTable::class];
        $this->Periodes = TableRegistry::getTableLocator()->get('Periodes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Periodes);

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
