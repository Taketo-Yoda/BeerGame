<?php
declare(strict_types=1);

namespace App\Model\Enum;

/**
 * BookStatusEnum
 *
 */
enum BookStatusEnum : string
{
    case Unbooked = 'Unbooked';
    case Booked = 'Booked' ;
}
