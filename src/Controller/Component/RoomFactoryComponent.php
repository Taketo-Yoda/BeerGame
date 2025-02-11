<?php
declare(strict_types=1);
namespace App\Controller\Component;

use App\Model\Enum\DifficultiesEnum;
use App\Model\Enum\RoomStatusEnum;
use App\Model\Enum\MemberStatusEnum;
use App\Model\Entity\Member;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

/**
 * RoomFactoryComponent
 */
class RoomFactoryComponent extends Component
{
    public $components = ['RoomService'];

    /**
     * ゲームルーム作成
     */
    public function create(?string $roomName, DifficultiesEnum $difficulty, int $num_of_turn, string $createdBy): void
    {
        $connection = ConnectionManager::get('default');
        $connection->begin();
        $roomTable = TableRegistry::getTableLocator()->get('Rooms');
        $room = $roomTable->newEmptyEntity();
        $room->name = $roomName;
        $room->status = RoomStatusEnum::Standby->value;
        $room->difficulty = $difficulty->value;
        $room->num_of_turn = $num_of_turn;
        $room->created_by = $createdBy;
        $room->updated_by = $createdBy;
        $createdRoom = $roomTable->save($room);
        if ($createdRoom === false) {
            $connection->rollback();
            throw new ServiceException('E00010', __(__('E00010'), __('Room')));
        }
        $membersTable = TableRegistry::getTableLocator()->get('Members');
        for ($i = 0; $i < 4; $i++) {
            $member = $membersTable->newEmptyEntity();
            $member->room_id = $createdRoom->id;
            if ($i == 0) {
                $member->account = $createdBy;
                $member->owner_flg = true;
            } else {
                $member->owner_flg = false;
            }
            $member->status = MemberStatusEnum::Ready->value;
            $member->created_by = $createdBy;
            $member->updated_by = $createdBy;
            if ($membersTable->save($member) === false) {
                $connection->rollback();
                throw new ServiceException('E00010', __(__('E00010'), __('Member')));
            }
        }
        // システムチャットメッセージ追加
        $this->RoomService->pushChatMessage($createdRoom->id, __('S00002'), $createdBy, true);

        $connection->commit();
    }

}