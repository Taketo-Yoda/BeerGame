<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
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
                'account' => '8ba3c16b-803b-44e5-99db-bf1f95f6b799',
                'password' => 'Lorem ipsum dolor sit amet',
                'nickname' => 'Lorem ipsum dolor sit amet',
                'participate_cnt' => 1,
                'auth_name' => 'Lorem ipsum dolor sit amet',
                'last_login' => 1656069686,
                'version' => 1,
                'created' => 1656069686,
                'created_by' => 'Lorem ipsum dolor sit amet',
                'updated' => 1656069686,
                'updated_by' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
