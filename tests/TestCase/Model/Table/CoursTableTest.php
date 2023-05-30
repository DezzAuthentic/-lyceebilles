<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CoursTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CoursTable Test Case
 */
class CoursTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CoursTable
     */
    public $Cours;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cours',
        'app.groupes',
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
        $config = TableRegistry::getTableLocator()->exists('Cours') ? [] : ['className' => CoursTable::class];
        $this->Cours = TableRegistry::getTableLocator()->get('Cours', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cours);

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
