<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DemandesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DemandesTable Test Case
 */
class DemandesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DemandesTable
     */
    public $Demandes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.demandes',
        'app.tuteurs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Demandes') ? [] : ['className' => DemandesTable::class];
        $this->Demandes = TableRegistry::getTableLocator()->get('Demandes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Demandes);

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
