<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FamillesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FamillesTable Test Case
 */
class FamillesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FamillesTable
     */
    public $Familles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.familles',
        'app.etablissements',
        'app.produits'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Familles') ? [] : ['className' => FamillesTable::class];
        $this->Familles = TableRegistry::getTableLocator()->get('Familles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Familles);

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
