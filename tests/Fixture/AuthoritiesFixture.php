<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AuthoritiesFixture
 */
class AuthoritiesFixture extends TestFixture
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
                'auth_name' => '0a44b09f-418c-47ce-8ca2-939c873c730c',
                'description' => 'Lorem ipsum dolor sit amet',
                'version' => 1,
                'created' => 1656080376,
                'created_by' => 'Lorem ipsum dolor sit amet',
                'updated' => 1656080376,
                'updated_by' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
