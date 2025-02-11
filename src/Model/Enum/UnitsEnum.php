<?php
declare(strict_types=1);

namespace App\Model\Enum;

/**
 * UnitsEnum
 *
 */
enum UnitsEnum : string
{
    case Retailer = 'Retailer';
    case Wholesale = 'Wholesale' ;
    case Distributor = 'Distributor';
    case Factory = 'Factory';
}
