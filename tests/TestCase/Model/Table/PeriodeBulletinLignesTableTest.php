<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PeriodeBulletinLignesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PeriodeBulletinLignesTable Test Case
 */
class PeriodeBulletinLignesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PeriodeBulletinLignesTable
     */
    public $PeriodeBulletinLignes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.periode_bulletin_lignes',
        'app.periode_bulletins',
        'app.cours'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PeriodeBulletinLignes') ? [] : ['className' => PeriodeBulletinLignesTable::class];
        $this->PeriodeBulletinLignes = TableRegistry::getTableLocator()->get('PeriodeBulletinLignes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PeriodeBulletinLignes);

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
