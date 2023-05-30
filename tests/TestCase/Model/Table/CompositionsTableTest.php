<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CompositionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CompositionsTable Test Case
 */
class CompositionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CompositionsTable
     */
    public $Compositions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.compositions',
        'app.cours'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Compositions') ? [] : ['className' => CompositionsTable::class];
        $this->Compositions = TableRegistry::getTableLocator()->get('Compositions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Compositions);

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
