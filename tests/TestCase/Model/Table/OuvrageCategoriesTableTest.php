<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OuvrageCategoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OuvrageCategoriesTable Test Case
 */
class OuvrageCategoriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OuvrageCategoriesTable
     */
    public $OuvrageCategories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ouvrage_categories'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('OuvrageCategories') ? [] : ['className' => OuvrageCategoriesTable::class];
        $this->OuvrageCategories = TableRegistry::getTableLocator()->get('OuvrageCategories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OuvrageCategories);

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
}
