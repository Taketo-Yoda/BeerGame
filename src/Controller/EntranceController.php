<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Enum\RoomStatusEnum;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Http\Exception\NotFoundException;

/**
 * Entrance Controller
 *
 */
class EntranceController extends AbstractController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        // 参加中のゲームがあればRoomIndexへリダイレクトする
        $this->checkEntriedRoom();
        // index情報取得
        $this->loadComponent('EntranceService');
        $rooms = $this->EntranceService->getActiveRooms();
        $this->set(compact('rooms'));
    }

    /**
     * entry method
     */
    public function entry()
    {
        if ($this->request->is('get')) {
            throw new NotFoundException();
        }
        $data = $this->request->getData();
        $roomId = $data['id'];
        if ($this->Str->isNullOrEmpty($roomId)) {
            throw new NotFoundException();
        }
        $room = $this->checkEntriedRoom(true);
        
        // エントリ処理
        $this->RoomService->entry((int)$roomId, $this->Auth->User('account'), $this->Auth->User('nickname'));
        $this->Flash->success(__('S00001'));
        return $this->redirect(['controller' => 'Room', 'action' => 'assignment', $roomId]);
        
    }

    /**
     * エントリ済みのゲームが存在する場合
     * リダイレクトを行う。
     */
    private function checkEntriedRoom(?bool $dispMsgFlg = false)
    {
        $account = $this->Auth->User('account');
        $this->loadComponent('RoomService');
        $room = $this->RoomService->getEntriedRoom($account);
        if (!is_null($room)){
            // 既に他のゲームにエントリしている場合はリダイレクト
            if ($dispMsgFlg) {
                $this->Flash->success(__('W00001'));
            }
            if ($room['status'] === RoomStatusEnum::Standby->value || $room['status'] === RoomStatusEnum::Ready->value) {
                return $this->redirect(['controller' => 'Room', 'action' => 'assignment', $room['id']]);
            } else {
                return $this->redirect(['controller' => 'Room', 'action' => 'index', $room['id']]);
            }
        }
    }
}
