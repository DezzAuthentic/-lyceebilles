<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ElevesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ElevesTable Test Case
 */
class ElevesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ElevesTable
     */
    public $Eleves;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.eleves',
        'app.tuteurs',
        'app.users',
        'app.etablissements',
        'app.inscriptions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Eleves') ? [] : ['className' => ElevesTable::class];
        $this->Eleves = TableRegistry::getTableLocator()->get('Eleves', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Eleves);

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
