<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AnneesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AnneesTable Test Case
 */
class AnneesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AnneesTable
     */
    public $Annees;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.annees',
        'app.etablissements',
        'app.periodes',
        'app.promotions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Annees') ? [] : ['className' => AnneesTable::class];
        $this->Annees = TableRegistry::getTableLocator()->get('Annees', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Annees);

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
