<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TuteurSecondairesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TuteurSecondairesTable Test Case
 */
class TuteurSecondairesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TuteurSecondairesTable
     */
    public $TuteurSecondaires;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.tuteur_secondaires',
        'app.tuteurs',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TuteurSecondaires') ? [] : ['className' => TuteurSecondairesTable::class];
        $this->TuteurSecondaires = TableRegistry::getTableLocator()->get('TuteurSecondaires', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TuteurSecondaires);

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
