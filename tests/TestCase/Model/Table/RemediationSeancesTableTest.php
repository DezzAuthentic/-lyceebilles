<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RemediationSeancesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RemediationSeancesTable Test Case
 */
class RemediationSeancesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RemediationSeancesTable
     */
    public $RemediationSeances;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.remediation_seances',
        'app.remediations'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('RemediationSeances') ? [] : ['className' => RemediationSeancesTable::class];
        $this->RemediationSeances = TableRegistry::getTableLocator()->get('RemediationSeances', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RemediationSeances);

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
