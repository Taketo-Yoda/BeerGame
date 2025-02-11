<?php
declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Enum\BookStatusEnum;
use App\Model\Enum\DifficultiesEnum;
use Cake\ORM\Entity;

/**
 * Book Entity
 *
 * @property int $member_id
 * @property int $turn
 * @property string $status
 * @property int|null $num_of_received
 * @property int|null $num_of_order_receive
 * @property int|null $num_of_inventory
 * @property int|null $num_of_backordered
 * @property int|null $num_of_order
 * @property int $version
 * @property \Cake\I18n\FrozenTime $created
 * @property string $created_by
 * @property \Cake\I18n\FrozenTime $updated
 * @property string $updated_by
 *
 * @property \App\Model\Entity\Member $member
 */
class Book extends AbstractEntity
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
        'member_id' => false,
        'turn' => false,
        'status' => true,
        'num_of_received' => true,
        'num_of_inventory' => true,
        'num_of_backordered' => true,
        'num_of_order' => true,
        'num_of_purchasing' => true,
        'num_of_shipping' => true,
        'member' => true,
    ];

    public function initialize (int $memberId, int $turn, string $account):void
    {
        $this->member_id = $memberId;
        $this->turn = $turn;
        $this->status = BookStatusEnum::Unbooked->value;
        if ($turn == 1) {
            // 入荷数初期値設定
            $this->num_of_received = 4;
            // 受注数設定
            $this->num_of_order = 4;
            // 在庫数初期値設定
            $this->num_of_inventory = 8;
            // 配送数初期値設定
            $this->num_of_shipping = 4;
        } else if ($turn <= 5) {
            // 受注数設定
            $this->num_of_order = 4;
        } else {
            // 受注数設定
            $this->num_of_order = 8;
        }
        $this->num_of_backordered = 0;
        $this->initializeWhoColumn($account);
    }
}
