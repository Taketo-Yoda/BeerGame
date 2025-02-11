<?php
declare(strict_types=1);

namespace App\Model\Enum;

/**
 * MemberStatusEnum
 *
 */
enum MemberStatusEnum : string
{
    case Ready = 'Ready';
    case Wait = 'Wait';
    case Transport = 'Transport';
    case OrderReceive = 'Order Receive';
    case Send = 'Send';
    case Order = 'Order';
    case ProductionInstruct = 'Production Instruct';
}
