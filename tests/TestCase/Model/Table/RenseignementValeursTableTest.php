<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RenseignementValeursTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RenseignementValeursTable Test Case
 */
class RenseignementValeursTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RenseignementValeursTable
     */
    public $RenseignementValeurs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.renseignement_valeurs',
        'app.renseignements',
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
        $config = TableRegistry::getTableLocator()->exists('RenseignementValeurs') ? [] : ['className' => RenseignementValeursTable::class];
        $this->RenseignementValeurs = TableRegistry::getTableLocator()->get('RenseignementValeurs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RenseignementValeurs);

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
