<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BooksFixture
 */
class BooksFixture extends TestFixture
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
                'member_id' => 1,
                'turn' => 1,
                'status' => 'Lorem ipsum dolor sit amet',
                'num_of_received' => 1,
                'num_of_order_receive' => 1,
                'num_of_inventory' => 1,
                'num_of_backordered' => 1,
                'num_of_order' => 1,
                'version' => 1,
                'created' => 1660192623,
                'created_by' => 'Lorem ipsum dolor sit amet',
                'updated' => 1660192623,
                'updated_by' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
