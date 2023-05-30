<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AnneeBulletinsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AnneeBulletinsTable Test Case
 */
class AnneeBulletinsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AnneeBulletinsTable
     */
    public $AnneeBulletins;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.annee_bulletins',
        'app.affectations'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('AnneeBulletins') ? [] : ['className' => AnneeBulletinsTable::class];
        $this->AnneeBulletins = TableRegistry::getTableLocator()->get('AnneeBulletins', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AnneeBulletins);

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
