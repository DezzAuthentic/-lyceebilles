<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InscriptionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InscriptionsTable Test Case
 */
class InscriptionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\InscriptionsTable
     */
    public $Inscriptions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.inscriptions',
        'app.eleves',
        'app.promotions',
        'app.engagements',
        'app.affectations'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Inscriptions') ? [] : ['className' => InscriptionsTable::class];
        $this->Inscriptions = TableRegistry::getTableLocator()->get('Inscriptions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Inscriptions);

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
