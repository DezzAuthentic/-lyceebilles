<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmpruntsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmpruntsTable Test Case
 */
class EmpruntsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EmpruntsTable
     */
    public $Emprunts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.emprunts',
        'app.users',
        'app.ouvrages'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Emprunts') ? [] : ['className' => EmpruntsTable::class];
        $this->Emprunts = TableRegistry::getTableLocator()->get('Emprunts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Emprunts);

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
