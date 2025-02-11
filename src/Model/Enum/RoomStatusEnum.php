<?php
declare(strict_types=1);

namespace App\Model\Enum;

/**
 * RoomStatusEnum
 *
 */
enum RoomStatusEnum : string
{
    case Standby = 'Standby';
    case Ready = 'Ready';
    case Gaming = 'Gaming';
    case Canceled = 'Canceled';
    case Finished = 'Finished';
}
