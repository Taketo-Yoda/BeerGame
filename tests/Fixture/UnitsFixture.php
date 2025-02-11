<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UnitsFixture
 */
class UnitsFixture extends TestFixture
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
                'name' => '635a47d5-bc5c-455e-bbec-d6c77d267ca8',
                'display_seq' => 1,
                'description' => 'Lorem ipsum dolor sit amet',
                'version' => 1,
                'created' => 1656660693,
                'created_by' => 'Lorem ipsum dolor sit amet',
                'updated' => 1656660693,
                'updated_by' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
