<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use App\Controller\Component\ServiceException;
use App\Model\Enum\DifficultiesEnum;
use App\Model\Enum\RoomStatusEnum;
use App\Model\Enum\UnitsEnum;
use Cake\Log\Log;
use Cake\Http\Exception\NotFoundException;

/**
 * Room Controller
 *
 */
class RoomController extends AbstractController
{

    public function initialize():void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('room_base');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($id = null)
    {
        if(is_null($id)){
            throw new NotFoundException();
        }
        $roomsTable = TableRegistry::getTableLocator()->get('Rooms');
        $room = $roomsTable->get($id, [
            'contain' => ['members'],
        ]);
        if ($room->status !== RoomStatusEnum::Gaming->value) {
            throw new NotFoundException();
        }

        $roomId = $id;
        $account = $this->Auth->User('account');
        $difficulty = $room->difficulty;
        $numOfTurn = $room->num_of_turn;
        $currentTurn = $room->current_turn;
        $retailer = $wholesale = $distributor = $factory = null;
        $retMemName = $wholMemName = $distMemName = $factMemName = null;
        $isWatcher = true;
        $myMemberId = null;
        $usersTable = TableRegistry::getTableLocator()->get('Users');
        foreach ($room->members as $member) {
            $user = $usersTable->get($member->account);
            if ($account == $member->account) {
                $isWatcher = false;
                $myMemberId = $member->id;
            }
            switch ($member->unit) {
                case UnitsEnum::Retailer->value:
                    $retailer = $member;
                    $retMemName = $user->nickname;
                    break;
                case UnitsEnum::Wholesale->value:
                    $wholesale = $member;
                    $wholMemName = $user->nickname;
                    break;
                case UnitsEnum::Distributor->value:
                    $distributor = $member;
                    $distMemName = $user->nickname;
                    break;
                case UnitsEnum::Factory->value:
                    $factory = $member;
                    $factMemName = $user->nickname;
                    break;
            }
        }
        $this->set(compact('roomId', 'difficulty', 'numOfTurn', 'currentTurn', 'retailer', 'wholesale', 'distributor', 'factory', 'retMemName', 'wholMemName', 'distMemName', 'factMemName', 'account', 'isWatcher', 'myMemberId'));
    }

    /**
     * add method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function add()
    {
        $this->viewBuilder()->setLayout('default');
        if ($this->request->is('get')) {
            $difficultiesTable = TableRegistry::getTableLocator()->get('Difficulties');
            $difficulties = $difficultiesTable->find()->select(['name', 'default_num_of_turn'])->order(['display_seq' => 'ASC']);
            $this->set(compact('difficulties'));
        } else {
            $data = $this->request->getData();
            $this->loadComponent('RoomFactory');
            $difficulty = DifficultiesEnum::tryFrom($data['difficulty']) ?? DifficultiesEnum::tutorial;
            $numOfTurn = $data['num_of_turn'];
            if ($this->Str->isNullOrEmpty($numOfTurn)) {
                $this->flashError('E00004');
                return;
            }
            // TODO:整数値チェック
            if (!is_numeric($numOfTurn)) {
                $this->flashError('E00009');
                return;
            }
            try {
                $this->RoomFactory->create($data['room_name'], $difficulty, (int)$numOfTurn, $this->Auth->User('account'));
            } catch (ServiceException $e) {
                $this->flashError($e->errorCode);
                return;
            }
            $this->Flash->success(__('The room has been created.'));
            return $this->redirect(['controller' => 'Entrance', 'action' => 'index']);
        }
    }

    /**
     * assignment method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function assignment($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException();
        }
        $roomId = $id;
        // オーナーか判定
        $account = $this->Auth->User('account');
        $membersTable = TableRegistry::getTableLocator()->get('Members');
        $isOwner = $membersTable->find()->select(['owner_flg'])->where(['room_id' => $id, 'account' => $account])->first()['owner_flg'];
        if ($this->request->is('get')) {
            // unit取得
            $unitsTable = TableRegistry::getTableLocator()->get('Units');
            $units = $unitsTable->find()->select(['name'])->order(['display_seq' => 'ASC']);
            $this->set(compact('roomId', 'id', 'units', 'isOwner'));
        } else {
            // オーナーか判定
            if (!$isOwner) {
                throw new NotFoundException();
            }
            // パラメータ取得
            $data = $this->request->getData();

            // パラメータチェック
            $retailerAccount = $data['Retailer'];
            $wholesaleAccount = $data['Wholesale'];
            $distributorAccount = $data['Distributor'];
            $factoryAccount = $data['Factory'];
            if ($this->Str->hasNullOrEmpty([$retailerAccount, $wholesaleAccount, $distributorAccount, $factoryAccount])) {
                $this->flashError('E00017');
                return;
            }
                // アサイン処理
            $this->loadComponent('RoomService');
            try {
                $this->RoomService->assign((int) $id, $account, $retailerAccount, $wholesaleAccount, $distributorAccount, $factoryAccount);
            } catch(ServiceException $e) {
                $this->flashError($e->errorMsg);
                return;
            }
            // ゲームルームへリダイレクト
            return $this->redirect(['controller' => 'Room', 'action' => 'index', $id]);
        }
    }

    /**
     * 退室
     */
    public function leave()
    {
        $data = $this->request->getData();
        $id = $data['id'];
        if (is_null($id) || !is_numeric($id)) {
            throw new NotFoundException();
        }
        if ($this->request->is('get')) {
            throw new NotFoundException();
        }
        $this->loadComponent('RoomService');
        try{
            $this->RoomService->leave((int)$id, $this->Auth->User('account'), $this->Auth->User('nickname'));
        } catch(ServiceException $e) {
            $this->flashError($e->errorMsg);
            return;
        }
        // 成功時はエントランスへリダイレクト
        return $this->redirect(['controller' => 'Entrance', 'action' => 'index']);

    }

    /**
     * get members method
     * @return Json
     */
    public function getMembers($id = null)
    {
        $this->viewBuilder()->setClassName('Json');
        $this->loadComponent('RoomService');
        $result = $this->RoomService->getMembers($id);
        $this->set('roomInfo', $result);
        $this->viewBuilder()->setOption('serialize', ['roomInfo']);

    }

    /**
     * 数量情報取得
     */
    public function unitInfo($roomId = null)
    {
        $this->viewBuilder()->setClassName('Json');
        $response = [];
        $memberId = $this->request->getQuery('memberId');
        // パラメータチェック
        if ($this->Str->hasNullOrEmpty([$roomId, $memberId]) || !is_numeric($roomId) || !is_numeric($memberId)) {
            $this->set('unitInfo', $response);
            $this->set('errorMsg', __('E00018'));
            $this->viewBuilder()->setOption('serialize', ['unitInfo', 'errorMsg']);
            return;
        }

        $this->loadComponent('RoomService');
        $response = $this->RoomService->getUnitInfo((int) $roomId, (int) $memberId);
        $response['isPlayer'] = $response['account'] == $this->Auth->User('account');
        $this->set('unitInfo', $response);
        $this->viewBuilder()->setOption('serialize', ['unitInfo']);
        return;

    }

    /**
     * チャット取得
     */
    public function getChat()
    {
        $this->viewBuilder()->setClassName('Json');
        $response = ['messages' => [], 'offset' => 0];
        $roomId = $this->request->getQuery('roomId');
        $offset = $this->request->getQuery('offset');
        if ($this->Str->hasNullOrEmpty([$roomId, $offset])) {
            $this->set('chatInfo', $response);
            $this->viewBuilder()->setOption('serialize', ['chatInfo']);
            return;
        }
        if (!is_numeric($roomId) || !is_numeric($offset)) {
            $this->set('chatInfo', $response);
            $this->viewBuilder()->setOption('serialize', ['chatInfo']);
            return;
        }

        $this->loadComponent('RoomService');
        $messages = $this->RoomService->getChatMessages((int)$roomId, (int)$offset);
        $returnOffset = $offset + count($messages);
        $response['messages'] = $messages;
        $response['offset'] = $returnOffset;
        $this->set('chatInfo', $response);
        $this->viewBuilder()->setOption('serialize', ['chatInfo']);
    }

    /**
     * チャット送信
     */
    public function postChat(){
        $this->viewBuilder()->setLayout('ajax');
        if (!$this->request->is('post')) {
            throw new NotFoundException();
        }
        $data = $this->request->getData();
        $roomId = $data['id'];
        $message = $data['message'];
        if ($this->Str->hasNullOrEmpty([$roomId, $message])) {
            return;
        }
        if (!is_numeric($roomId)) {
            return;
        }
        $this->loadComponent('RoomService');
        $this->RoomService->pushChatMessage((int)$roomId, $message, $this->Auth->User('account'), false);
        return;
    }
}
