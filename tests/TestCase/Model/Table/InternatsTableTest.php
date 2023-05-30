<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InternatsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InternatsTable Test Case
 */
class InternatsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\InternatsTable
     */
    public $Internats;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.internats',
        'app.scolarites'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Internats') ? [] : ['className' => InternatsTable::class];
        $this->Internats = TableRegistry::getTableLocator()->get('Internats', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Internats);

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
