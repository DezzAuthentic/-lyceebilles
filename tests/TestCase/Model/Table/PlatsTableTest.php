<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PlatsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PlatsTable Test Case
 */
class PlatsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PlatsTable
     */
    public $Plats;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.plats',
        'app.menus'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Plats') ? [] : ['className' => PlatsTable::class];
        $this->Plats = TableRegistry::getTableLocator()->get('Plats', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Plats);

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
