<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DifficultiesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DifficultiesTable Test Case
 */
class DifficultiesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DifficultiesTable
     */
    protected $Difficulties;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Difficulties',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Difficulties') ? [] : ['className' => DifficultiesTable::class];
        $this->Difficulties = $this->getTableLocator()->get('Difficulties', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Difficulties);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DifficultiesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
