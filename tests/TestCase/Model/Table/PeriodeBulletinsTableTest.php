<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PeriodeBulletinsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PeriodeBulletinsTable Test Case
 */
class PeriodeBulletinsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PeriodeBulletinsTable
     */
    public $PeriodeBulletins;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.periode_bulletins',
        'app.periodes',
        'app.affectations',
        'app.periode_bulletin_lignes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PeriodeBulletins') ? [] : ['className' => PeriodeBulletinsTable::class];
        $this->PeriodeBulletins = TableRegistry::getTableLocator()->get('PeriodeBulletins', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PeriodeBulletins);

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
