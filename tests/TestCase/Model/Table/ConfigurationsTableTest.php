<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConfigurationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ConfigurationsTable Test Case
 */
class ConfigurationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ConfigurationsTable
     */
    public $Configurations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.configurations',
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
        $config = TableRegistry::getTableLocator()->exists('Configurations') ? [] : ['className' => ConfigurationsTable::class];
        $this->Configurations = TableRegistry::getTableLocator()->get('Configurations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Configurations);

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
}
