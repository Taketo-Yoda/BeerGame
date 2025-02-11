<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MembersFixture
 */
class MembersFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'room_id' => 1,
                'account' => 'Lorem ipsum dolor sit amet',
                'owner_flg' => 1,
                'unit' => 'Lorem ipsum dolor sit amet',
                'status' => 'Lorem ipsum dolor sit amet',
                'version' => 1,
                'created' => 1656508356,
                'created_by' => 'Lorem ipsum dolor sit amet',
                'updated' => 1656508356,
                'updated_by' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
