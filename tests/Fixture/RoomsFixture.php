<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RoomsFixture
 */
class RoomsFixture extends TestFixture
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
                'name' => 'Lorem ipsum dolor sit amet',
                'status' => 'Lorem ipsum dolor sit amet',
                'difficulty' => 'Lorem ipsum dolor sit amet',
                'num_of_turn' => 1,
                'start_date' => 1656329456,
                'end_date' => 1656329456,
                'version' => 1,
                'created' => 1656329456,
                'created_by' => 'Lorem ipsum dolor sit amet',
                'updated' => 1656329456,
                'updated_by' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
