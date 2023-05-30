<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OuvragesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OuvragesTable Test Case
 */
class OuvragesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OuvragesTable
     */
    public $Ouvrages;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ouvrages',
        'app.ouvrage_categories',
        'app.emprunts'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Ouvrages') ? [] : ['className' => OuvragesTable::class];
        $this->Ouvrages = TableRegistry::getTableLocator()->get('Ouvrages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Ouvrages);

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
