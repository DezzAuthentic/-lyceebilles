<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InscriptionFraisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InscriptionFraisTable Test Case
 */
class InscriptionFraisTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\InscriptionFraisTable
     */
    public $InscriptionFrais;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.inscription_frais',
        'app.frais',
        'app.promotions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('InscriptionFrais') ? [] : ['className' => InscriptionFraisTable::class];
        $this->InscriptionFrais = TableRegistry::getTableLocator()->get('InscriptionFrais', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->InscriptionFrais);

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
