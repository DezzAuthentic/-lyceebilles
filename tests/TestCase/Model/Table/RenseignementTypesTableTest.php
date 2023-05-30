<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RenseignementTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RenseignementTypesTable Test Case
 */
class RenseignementTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RenseignementTypesTable
     */
    public $RenseignementTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.renseignement_types',
        'app.etablissements',
        'app.renseignements'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('RenseignementTypes') ? [] : ['className' => RenseignementTypesTable::class];
        $this->RenseignementTypes = TableRegistry::getTableLocator()->get('RenseignementTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RenseignementTypes);

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
