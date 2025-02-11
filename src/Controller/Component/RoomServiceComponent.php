<?php
declare(strict_types=1);
namespace App\Controller\Component;

use App\Controller\Component\ServiceException;
use App\Model\Enum\RoomStatusEnum;
use App\Model\Enum\UnitsEnum;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

/**
 * RoomServiceComponent
 */
class RoomServiceComponent extends Component
{
    /**
     * アクティブなルームの一覧取得
     */
    public function getMembers($id=null): array
    {
        /// 空のレスポンス作成
        $result = [
            'users' => [],
            'status' => ''
        ];
        // IDが設定されていない場合は空のレスポンスを返す
        if (is_null($id)) {
            return $result;
        }

        // メンバー取得
        $connection = ConnectionManager::get('default');
        $sql = <<<SQL
            SELECT
                u.account AS account
               ,u.nickname AS nickname
            FROM
                members m
            JOIN users u
                ON u.account = m.account
            WHERE 1=1
            AND m.room_id = :id
        SQL;
        $bindParams = [
            'id' => $id,
        ];
        $result['users'] = $connection->execute($sql, $bindParams)->fetchAll('assoc');

        // ステータス取得
        $sql = <<<SQL
            SELECT
                status
            FROM
                rooms
            WHERE 1=1
            AND id = :id
        SQL;
        $result['status'] = $connection->execute($sql, $bindParams)->fetch('assoc')['status'];

        return $result;
    }

    /**
     * エントリ済みのRoom情報取得
     * @param string $account
     */
    public function getEntriedRoom(string $account): ?array {
        $connection = ConnectionManager::get('default');
        $sql = <<<SQL
            SELECT
                r.id AS id
               ,r.status AS status
            FROM
                members m
            JOIN rooms r
                ON r.id = m.room_id
            JOIN room_status s
                ON s.name = r.status
                AND s.display_flg = true
            WHERE 1=1
            AND m.account = :account
        SQL;
        $bindParams = [
            'account' => $account,
        ];
        $result = $connection->execute($sql, $bindParams)->fetch('assoc');
        if (empty($result['id'])) {
            return null;
        } else {
            return $result;
        }
    }

    /**
     * エントリ処理
     */
    public function entry(int $roomId, string $account, string $nickname):void
    {
        $connection = ConnectionManager::get('default');
        $connection->begin();
        // Roomsテーブルにロックをかける
        $lockQuery = <<<SQL
            SELECT
                id
            FROM
                rooms
            WHERE 1=1
            AND id = :id
            FOR UPDATE NOWAIT
        SQL;
        $lockBindParam = ['id' => $roomId];
        $lockedData = [];
        try {
            $lockedData = $connection->execute($lockQuery, $lockBindParam)->fetch('assoc');
        } catch (Exception $e) {
            $connection->rollback();
            throw new ServiceException('E00011');
        }
        if (empty($lockedData['id'])) {
            $connection->rollback();
            throw new ServiceException('E00012');
        }
        // メンバー情報取得
        $membersTable = TableRegistry::getTableLocator()->get('Members');
        $memberEntity = $membersTable->find()->where(['room_id' => $lockedData['id'], 'account IS NULL'])->first();
        if (empty($memberEntity)) {
            $connection->rollback();
            throw new ServiceException('E00013');
        };
        $memberEntity->entry($account);
        $membersTable->save($memberEntity);
        $entryMessage = __('S00003 {0}', [$nickname]);
        // チャットへ入室メッセージを追加
        $this->pushChatMessage($lockedData['id'], $entryMessage, $account, true);

        // 入室による状態変更要否チェック
        $notEntryCnt = $membersTable->find()->where(['room_id' => $lockedData['id'], 'account IS NULL'])->count();
        if ($notEntryCnt === 0) {
            // メンバーが揃った場合は部屋のステータスを更新する。
            $roomsTable = TableRegistry::getTableLocator()->get('Rooms');
            $roomEntity = $roomsTable->get($lockedData['id']);
            $roomEntity->ready($account);
            $roomsTable->save($roomEntity);
            // チャットへ部屋のステータスが更新されたことを追加
            $this->pushChatMessage($lockedData['id'], __('S00004'), $account, true);
        }
        $connection->commit();
    }

    /**
     * 退室
     */
    public function leave(int $roomId, string $account, string $nickname)
    {
        $connection = ConnectionManager::get('default');
        $connection->begin();
        // Roomsテーブルにロックをかける
        $lockQuery = <<<SQL
            SELECT
                id, status
            FROM
                rooms
            WHERE 1=1
            AND id = :id
            FOR UPDATE NOWAIT
        SQL;
        $lockBindParam = ['id' => $roomId];
        $lockedData = [];
        try {
            $lockedData = $connection->execute($lockQuery, $lockBindParam)->fetch('assoc');
        } catch (Exception $e) {
            $connection->rollback();
            throw new ServiceException('E00011');
        }
        if (empty($lockedData['id'])) {
            $connection->rollback();
            throw new ServiceException('E00012');
        }
        if ($lockedData['status'] !== RoomStatusEnum::Standby->value) {
            $connection->rollback();
            throw new ServiceException('E00015');
        }

        // メンバー情報取得
        $membersTable = TableRegistry::getTableLocator()->get('Members');
        $memberEntity = $membersTable->find()->where(['room_id' => $lockedData['id'], 'account' => $account])->first();
        if (empty($memberEntity)) {
            $connection->rollback();
            throw new ServiceException('E00016');
        };
        $memberEntity->leave($account);
        $membersTable->save($memberEntity);
        $message = __(__('S00005 {0}'), [$nickname]);
        // チャットへ退室メッセージを追加
        $this->pushChatMessage($lockedData['id'], $message, $account, true);

        $connection->commit();
    }

    /**
     * チャットメッセージ取得
     * @param int $roomId ルームID
     * @param int $offset オフセット値
     * 
     * @return array 検索結果
     */
    public function getChatMessages(int $roomId, int $offset):array
    {
        $connection = ConnectionManager::get('default');
        $query = <<<SQL
            SELECT
                TO_CHAR(room_chat.posted_datetime, 'HH24:MI:SS') AS posted_datetime
               ,users.nickname AS nickname
               ,room_chat.message AS message
            FROM
                room_chat
            LEFT JOIN
                users
                ON users.account = room_chat.account
            WHERE 1=1
            AND room_id = :room_id
            ORDER BY
                room_chat.posted_datetime ASC
            OFFSET :offset
        SQL;
        $param = ['room_id' => $roomId, 'offset' => $offset];
        return $connection->execute($query, $param)->fetchAll('assoc');
    }

    /**
     * チャットメッセージ保存
     * @param int $roomId ルームID
     * @param string $message メッセージ
     * @param string $account アカウント
     * @param boolean $isSystemMessage trueの場合システムメッセージとして扱う
     */
    public function pushChatMessage(int $roomId, string $message, string $account, bool $isSystemMessage):void
    {
        $chatTable = TableRegistry::getTableLocator()->get('RoomChat');
        if($isSystemMessage) {
            $chatTable->query()->insert(['room_id', 'message', 'created_by', 'updated_by'])
                ->values([
                    'room_id' => $roomId,
                    'message' => $message,
                    'created_by' => $account,
                    'updated_by' => $account
                ])->execute();
        } else {
            $chatTable->query()->insert(['room_id', 'account', 'message', 'created_by', 'updated_by'])
                ->values([
                    'room_id' => $roomId,
                    'account' => $account,
                    'message' => $message,
                    'created_by' => $account,
                    'updated_by' => $account
                ])->execute();
        }

    }

    /**
     * アサイン処理
     * @param int $roomId ルームID
     * @param string $account 処理ユーザアカウント
     * @param string $retailerAccount 小売アカウント
     * @param string $wholesaleAccount 二次卸アカウント
     * @param string $distributorAccount 一次卸アカウント
     * @param string $factoryAccount 工場アカウント
     */
    public function assign(int $roomId, string $account, string $retailerAccount, string $wholesaleAccount, string $distributorAccount, string $factoryAccount):void
    {
        $connection = ConnectionManager::get('default');
        // Roomロック
        $roomLockQuery = <<<SQL
            SELECT
                id
            FROM
                rooms
            WHERE 1=1
            AND id = :id
            FOR UPDATE NOWAIT
        SQL;
        // Membersロック
        $membersLockQuery = <<<SQL
            SELECT
                id
            FROM
                members
            WHERE 1=1
            AND room_id = :id
            FOR UPDATE NOWAIT
        SQL;
        $lockBindParam = ['id' => $roomId];
        try {
            $connection->execute($roomLockQuery, $lockBindParam)->fetch('assoc');
            $connection->execute($membersLockQuery, $lockBindParam)->fetchAll('assoc');
        } catch (Exception $e) {
            $connection->rollback();
            throw new ServiceException('E00011');
        }

        // Rooms更新
        $roomsTable = TableRegistry::getTableLocator()->get('Rooms');
        $roomEntity = $roomsTable->get($roomId, ['contain' => ['members']]);
        $roomEntity->gameStart($account);
        $roomsTable->save($roomEntity);

        // Members更新
        $membersTable = TableRegistry::getTableLocator()->get('Members');
        $booksTable = TableRegistry::getTableLocator()->get('Books');
        $memberEntities = $roomEntity->members;
        foreach ($memberEntities as $memberEntity) {
            switch ($memberEntity->account) {
                case $retailerAccount:
                    $memberEntity->assign(UnitsEnum::Retailer, $account);
                    break;
                case $wholesaleAccount:
                    $memberEntity->assign(UnitsEnum::Wholesale, $account);
                    break;
                case $distributorAccount:
                    $memberEntity->assign(UnitsEnum::Distributor, $account);
                    break;
                case $factoryAccount:
                    $memberEntity->assign(UnitsEnum::Factory, $account);
                    break;
            }
            $membersTable->save($memberEntity);

            // Book作成
            for ($i = 1; $i <= $roomEntity->num_of_turn; $i++) {
                $book = $booksTable->newEmptyEntity();
                $book->initialize($memberEntity->id, $i, $account);
                $booksTable->save($book);
            }
        }

        // Commitして処理終了
        $connection->commit();
    }

    /**
     * 数量情報取得
     */
    public function getUnitInfo(int $roomId, int $memberId)
    {
        $connection = ConnectionManager::get('default');
        $query = <<<SQL
            SELECT
                members.status
               ,members.account
               ,books.num_of_received
               ,books.num_of_inventory
               ,books.num_of_backordered
               ,books.num_of_shipping
            FROM
                rooms
            JOIN
                members
                ON members.room_id = rooms.id
                AND members.id = :member_id
            JOIN
                books
                ON books.member_id = members.id
                AND books.turn = rooms.current_turn
            WHERE 1=1
            AND rooms.id = :room_id
        SQL;
        $param = ['room_id' => $roomId, 'member_id' => $memberId];
        return $connection->execute($query, $param)->fetch('assoc');
    }
}