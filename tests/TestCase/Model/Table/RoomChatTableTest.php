<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RoomChatTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RoomChatTable Test Case
 */
class RoomChatTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RoomChatTable
     */
    protected $RoomChat;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.RoomChat',
        'app.Rooms',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('RoomChat') ? [] : ['className' => RoomChatTable::class];
        $this->RoomChat = $this->getTableLocator()->get('RoomChat', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->RoomChat);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\RoomChatTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\RoomChatTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
