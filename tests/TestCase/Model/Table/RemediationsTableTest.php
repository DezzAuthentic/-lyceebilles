<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RemediationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RemediationsTable Test Case
 */
class RemediationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RemediationsTable
     */
    public $Remediations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.remediations',
        'app.professeurs',
        'app.matieres',
        'app.inscriptions',
        'app.remediation_seances'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Remediations') ? [] : ['className' => RemediationsTable::class];
        $this->Remediations = TableRegistry::getTableLocator()->get('Remediations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Remediations);

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
