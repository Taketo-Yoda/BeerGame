<?php
declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Enum\RoomStatusEnum;
use App\Model\Enum\UnitsEnum;
use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * Room Entity
 *
 * @property int $id
 * @property string|null $name
 * @property \App\Model\Enum\RoomStatusEnum $status
 * @property \App\Model\Enum\DifficultiesEnum $difficulty
 * @property int $num_of_turn
 * @property \Cake\I18n\FrozenTime|null $start_date
 * @property \Cake\I18n\FrozenTime|null $end_date
 * @property int $version
 * @property \Cake\I18n\FrozenTime $created
 * @property string $created_by
 * @property \Cake\I18n\FrozenTime $updated
 * @property string $updated_by
 *
 * @property \App\Model\Entity\Member[] $members
 */
class Room extends AbstractEntity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'name' => true,
        'status' => true,
        'difficulty' => true,
        'num_of_turn' => true,
        'current_turn' => true,
        'start_date' => true,
        'end_date' => true,
        'version' => true,
        'created' => true,
        'created_by' => true,
        'updated' => true,
        'updated_by' => true,
        'members' => true,
    ];

    /**
     * ゲームを待機状態にする
     */
    public function ready(string $account):void
    {
        $this->status = RoomStatusEnum::Ready->value;
        $this->updateWhoColumn($account);
    }

    /**
     * ゲームを開始状態にする
     */
    public function gameStart(string $account):void
    {
        $this->status = RoomStatusEnum::Gaming->value;
        $this->start_date = new FrozenTime();
        $this->updateWhoColumn($account);
    }

}
