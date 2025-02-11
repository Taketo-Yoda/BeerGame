<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RoomChat Entity
 *
 * @property int $room_id
 * @property \Cake\I18n\FrozenTime $posted_datetime
 * @property string|null $account
 * @property string $message
 * @property int $version
 * @property \Cake\I18n\FrozenTime $created
 * @property string $created_by
 * @property \Cake\I18n\FrozenTime $updated
 * @property string $updated_by
 *
 * @property \App\Model\Entity\Room $room
 */
class RoomChat extends Entity
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
        'posted_datetime' => true,
        'account' => true,
        'message' => true,
        'version' => true,
        'created' => true,
        'created_by' => true,
        'updated' => true,
        'updated_by' => true,
        'room' => true,
    ];
}
