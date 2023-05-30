<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RenseignementsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RenseignementsTable Test Case
 */
class RenseignementsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RenseignementsTable
     */
    public $Renseignements;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.renseignements',
        'app.renseignement_types',
        'app.renseignement_valeurs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Renseignements') ? [] : ['className' => RenseignementsTable::class];
        $this->Renseignements = TableRegistry::getTableLocator()->get('Renseignements', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Renseignements);

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
