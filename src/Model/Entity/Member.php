<?php
declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Enum\MemberStatusEnum;
use App\Model\Enum\UnitsEnum;
use Cake\ORM\Entity;

/**
 * Member Entity
 *
 * @property int $id
 * @property int $room_id
 * @property string|null $account
 * @property bool $owner_flg
 * @property string|null $unit
 * @property \App\Model\Enum\MemberStatusEnum $status
 * @property int $version
 * @property \Cake\I18n\FrozenTime $created
 * @property string $created_by
 * @property \Cake\I18n\FrozenTime $updated
 * @property string $updated_by
 *
 * @property \App\Model\Entity\Room $room
 * @property \App\Model\Entity\Book[] $books
 */
class Member extends AbstractEntity
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
        'room_id' => true,
        'account' => true,
        'owner_flg' => true,
        'unit' => true,
        'status' => true,
        'version' => true,
        'created' => true,
        'created_by' => true,
        'updated' => true,
        'updated_by' => true,
        'room' => true,
        'books' => true,
    ];

    /**
     * 入室
     * @param string $account 入室ユーザ
     */
    public function entry(string $account): void
    {
        $this->account = $account;
        $this->updateWhoColumn($this->account);
    }

    /**
     * 退室
     * @param string $account 退室ユーザ
     */
    public function leave(string $account): void
    {
        $this->account = null;
        $this->updateWhoColumn($account);
    }

    /**
     * アサイン
     */
    public function assign(UnitsEnum $units, string $account):void
    {
        $this->unit = $units->value;
        if ($units !== UnitsEnum::Retailer) {
            $this->status = MemberStatusEnum::Wait->value;
        } else {
            $this->status = MemberStatusEnum::Transport->value;
        }
        $this->updateWhoColumn($account);
    }

    /**
     * ready
     */
    public function ready(string $account):void
    {
        $this->status = MemberStatusEnum::Ready->value;
        $this->updateWhoColumn($account);
    }
}
