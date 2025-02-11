<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AuthoritiesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AuthoritiesTable Test Case
 */
class AuthoritiesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AuthoritiesTable
     */
    protected $Authorities;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Authorities',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Authorities') ? [] : ['className' => AuthoritiesTable::class];
        $this->Authorities = $this->getTableLocator()->get('Authorities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Authorities);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AuthoritiesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
