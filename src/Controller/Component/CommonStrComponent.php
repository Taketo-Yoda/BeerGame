<?php
declare(strict_types=1);
namespace App\Controller\Component;

use Cake\Controller\Component;

/**
 * 文字列共通処理
 */
class CommonStrComponent extends Component
{
    /**
     * 文字列Null判定処理
     * 入力引数がNullもしくは空文字の場合trueを返す
     * @param string 判定する文字列
     * @return bool
     */
    public function isNullOrEmpty(?string $str = null): bool
    {
        return is_null($str) || $str === "";
    }

    /**
     * 文字列Null判定処理（複数一括）
     * 入力された文字列の配列で、一つでもNullもしくは空文字が含まれている場合trueを返す。
     */
    public function hasNullOrEmpty(?array $array = null): bool
    {
        foreach($array as $str) {
            if ($this->isNullOrEmpty($str)) {
                return true;
            }
        }
        return false;
    }
}