<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RoomStatusTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RoomStatusTable Test Case
 */
class RoomStatusTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RoomStatusTable
     */
    protected $RoomStatus;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.RoomStatus',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('RoomStatus') ? [] : ['className' => RoomStatusTable::class];
        $this->RoomStatus = $this->getTableLocator()->get('RoomStatus', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->RoomStatus);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\RoomStatusTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
