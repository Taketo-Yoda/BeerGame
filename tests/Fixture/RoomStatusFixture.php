<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RoomStatusFixture
 */
class RoomStatusFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'room_status';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'name' => '2b6f224a-af6d-49e9-bea2-ba3ed8879bfe',
                'display_flg' => 1,
                'entry_flg' => 1,
                'watching_flg' => 1,
                'description' => 'Lorem ipsum dolor sit amet',
                'version' => 1,
                'created' => 1656591947,
                'created_by' => 'Lorem ipsum dolor sit amet',
                'updated' => 1656591947,
                'updated_by' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
