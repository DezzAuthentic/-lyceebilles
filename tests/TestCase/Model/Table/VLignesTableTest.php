<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VLignesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VLignesTable Test Case
 */
class VLignesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\VLignesTable
     */
    public $VLignes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.v_lignes',
        'app.produits',
        'app.ventes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('VLignes') ? [] : ['className' => VLignesTable::class];
        $this->VLignes = TableRegistry::getTableLocator()->get('VLignes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->VLignes);

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
