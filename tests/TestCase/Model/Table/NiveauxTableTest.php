<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NiveauxTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NiveauxTable Test Case
 */
class NiveauxTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\NiveauxTable
     */
    public $Niveaux;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.niveaux',
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
        $config = TableRegistry::getTableLocator()->exists('Niveaux') ? [] : ['className' => NiveauxTable::class];
        $this->Niveaux = TableRegistry::getTableLocator()->get('Niveaux', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Niveaux);

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
