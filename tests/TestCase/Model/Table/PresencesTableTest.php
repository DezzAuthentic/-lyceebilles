<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PresencesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PresencesTable Test Case
 */
class PresencesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PresencesTable
     */
    public $Presences;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.presences',
        'app.seances',
        'app.eleves'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Presences') ? [] : ['className' => PresencesTable::class];
        $this->Presences = TableRegistry::getTableLocator()->get('Presences', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Presences);

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
