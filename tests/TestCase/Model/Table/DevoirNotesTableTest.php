<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DevoirNotesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DevoirNotesTable Test Case
 */
class DevoirNotesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DevoirNotesTable
     */
    public $DevoirNotes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.devoir_notes',
        'app.devoirs',
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
        $config = TableRegistry::getTableLocator()->exists('DevoirNotes') ? [] : ['className' => DevoirNotesTable::class];
        $this->DevoirNotes = TableRegistry::getTableLocator()->get('DevoirNotes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DevoirNotes);

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
