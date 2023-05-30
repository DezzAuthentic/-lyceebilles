<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmployesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmployesTable Test Case
 */
class EmployesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EmployesTable
     */
    public $Employes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.employes',
        'app.users',
        'app.etablissements'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Employes') ? [] : ['className' => EmployesTable::class];
        $this->Employes = TableRegistry::getTableLocator()->get('Employes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Employes);

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
