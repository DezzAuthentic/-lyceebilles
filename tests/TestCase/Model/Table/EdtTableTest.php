<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EdtTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EdtTable Test Case
 */
class EdtTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EdtTable
     */
    public $Edt;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.edt',
        'app.salles',
        'app.cours'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Edt') ? [] : ['className' => EdtTable::class];
        $this->Edt = TableRegistry::getTableLocator()->get('Edt', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Edt);

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
