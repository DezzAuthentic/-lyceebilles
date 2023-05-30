<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FraisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FraisTable Test Case
 */
class FraisTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FraisTable
     */
    public $Frais;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.frais',
        'app.types',
        'app.niveaux',
        'app.series'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Frais') ? [] : ['className' => FraisTable::class];
        $this->Frais = TableRegistry::getTableLocator()->get('Frais', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Frais);

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
