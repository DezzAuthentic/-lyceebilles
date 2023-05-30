<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ExercicesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ExercicesTable Test Case
 */
class ExercicesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ExercicesTable
     */
    public $Exercices;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.exercices',
        'app.seances'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Exercices') ? [] : ['className' => ExercicesTable::class];
        $this->Exercices = TableRegistry::getTableLocator()->get('Exercices', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Exercices);

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
