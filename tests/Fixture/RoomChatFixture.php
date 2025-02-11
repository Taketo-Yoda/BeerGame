<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RoomChatFixture
 */
class RoomChatFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'room_chat';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'room_id' => 1,
                'posted_datetime' => 1658125637,
                'account' => 'Lorem ipsum dolor sit amet',
                'message' => 'Lorem ipsum dolor sit amet',
                'version' => 1,
                'created' => 1658125637,
                'created_by' => 'Lorem ipsum dolor sit amet',
                'updated' => 1658125637,
                'updated_by' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
