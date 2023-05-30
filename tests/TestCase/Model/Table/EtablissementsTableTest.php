<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EtablissementsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EtablissementsTable Test Case
 */
class EtablissementsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EtablissementsTable
     */
    public $Etablissements;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.etablissements',
        'app.configurations',
        'app.employes',
        'app.annees',
        'app.eleves',
        'app.matieres',
        'app.niveaux',
        'app.professeurs',
        'app.salles',
        'app.series',
        'app.tuteurs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Etablissements') ? [] : ['className' => EtablissementsTable::class];
        $this->Etablissements = TableRegistry::getTableLocator()->get('Etablissements', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Etablissements);

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
