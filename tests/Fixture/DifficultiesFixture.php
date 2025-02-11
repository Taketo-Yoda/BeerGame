<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DifficultiesFixture
 */
class DifficultiesFixture extends TestFixture
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
                'name' => '026c3bbe-5560-4440-967d-e02e6612d3e6',
                'default_num_of_turn' => 1,
                'display_seq' => 1,
                'description' => 'Lorem ipsum dolor sit amet',
                'version' => 1,
                'created' => 1656331109,
                'created_by' => 'Lorem ipsum dolor sit amet',
                'updated' => 1656331109,
                'updated_by' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
