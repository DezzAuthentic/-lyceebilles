<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InscriptionReglementsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InscriptionReglementsTable Test Case
 */
class InscriptionReglementsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\InscriptionReglementsTable
     */
    public $InscriptionReglements;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.inscription_reglements',
        'app.inscriptions',
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
        $config = TableRegistry::getTableLocator()->exists('InscriptionReglements') ? [] : ['className' => InscriptionReglementsTable::class];
        $this->InscriptionReglements = TableRegistry::getTableLocator()->get('InscriptionReglements', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->InscriptionReglements);

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
