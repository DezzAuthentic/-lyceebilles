<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CoefficientsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CoefficientsTable Test Case
 */
class CoefficientsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CoefficientsTable
     */
    public $Coefficients;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.coefficients',
        'app.promotions',
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
        $config = TableRegistry::getTableLocator()->exists('Coefficients') ? [] : ['className' => CoefficientsTable::class];
        $this->Coefficients = TableRegistry::getTableLocator()->get('Coefficients', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Coefficients);

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
