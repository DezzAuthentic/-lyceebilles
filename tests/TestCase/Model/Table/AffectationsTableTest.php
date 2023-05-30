<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AffectationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AffectationsTable Test Case
 */
class AffectationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AffectationsTable
     */
    public $Affectations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.affectations',
        'app.groupes',
        'app.inscriptions',
        'app.periode_bulletins'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Affectations') ? [] : ['className' => AffectationsTable::class];
        $this->Affectations = TableRegistry::getTableLocator()->get('Affectations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Affectations);

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
