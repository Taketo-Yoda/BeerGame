<?php
declare(strict_types=1);
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

/**
 * EntranceServiceComponent
 */
class EntranceServiceComponent extends Component
{
    /**
     * アクティブなルームの一覧取得
     */
    public function getActiveRooms(): array
    {
        $connection = ConnectionManager::get('default');
        $sql = <<<SQL
            SELECT
                rooms.id AS id
               ,rooms.name AS name
               ,rooms.status AS status
               ,room_status.entry_flg AS entry_flg
               ,room_status.watching_flg AS watching_flg
               ,ARRAY_TO_STRING(ARRAY_AGG(users.nickname ORDER BY members.id ASC), '/') AS members
            FROM
                rooms
            JOIN
                room_status
                ON room_status.name = rooms.status
                AND room_status.display_flg = true
            JOIN
                members
                ON members.room_id = rooms.id
            LEFT JOIN
                users
                ON users.account = members.account
            WHERE 1=1
            GROUP BY
                rooms.id
               ,rooms.name
               ,rooms.status
               ,room_status.entry_flg
               ,room_status.watching_flg
        SQL
        ;
        return $connection->execute($sql)->fetchAll('assoc');
    }

}