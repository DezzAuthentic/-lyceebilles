<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TuteursTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TuteursTable Test Case
 */
class TuteursTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TuteursTable
     */
    public $Tuteurs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.tuteurs',
        'app.users',
        'app.demandes',
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
        $config = TableRegistry::getTableLocator()->exists('Tuteurs') ? [] : ['className' => TuteursTable::class];
        $this->Tuteurs = TableRegistry::getTableLocator()->get('Tuteurs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Tuteurs);

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
