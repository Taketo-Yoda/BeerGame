<?php
declare(strict_types=1);
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\I18n\FrozenTime;

/**
 * 日時共通処理
 */
class CommonDateTimeComponent extends Component
{
    /**
     * 現在時刻取得
     * @return FrozenTime
     */
    public function now(): FrozenTime
    {
        return new FrozenTime();
    }

}