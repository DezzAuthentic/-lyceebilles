<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DessertsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DessertsTable Test Case
 */
class DessertsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DessertsTable
     */
    public $Desserts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.desserts',
        'app.etablissements',
        'app.menus'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Desserts') ? [] : ['className' => DessertsTable::class];
        $this->Desserts = TableRegistry::getTableLocator()->get('Desserts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Desserts);

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
