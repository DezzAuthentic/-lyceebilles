<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EnseigneesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EnseigneesTable Test Case
 */
class EnseigneesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EnseigneesTable
     */
    public $Enseignees;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.enseignees',
        'app.matieres',
        'app.professeurs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Enseignees') ? [] : ['className' => EnseigneesTable::class];
        $this->Enseignees = TableRegistry::getTableLocator()->get('Enseignees', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Enseignees);

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
