<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ScolaritesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ScolaritesTable Test Case
 */
class ScolaritesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ScolaritesTable
     */
    public $Scolarites;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.scolarites',
        'app.inscriptions',
        'app.internats',
        'app.scolarite_reglements'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Scolarites') ? [] : ['className' => ScolaritesTable::class];
        $this->Scolarites = TableRegistry::getTableLocator()->get('Scolarites', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Scolarites);

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
