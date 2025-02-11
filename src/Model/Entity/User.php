<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property string $account
 * @property string $password
 * @property string $nickname
 * @property int $participate_cnt
 * @property string $auth_name
 * @property \Cake\I18n\FrozenTime|null $last_login
 * @property int $version
 * @property \Cake\I18n\FrozenTime $created
 * @property string $created_by
 * @property \Cake\I18n\FrozenTime $updated
 * @property string $updated_by
 */
class User extends AbstractEntity
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
        'account' => true,
        'password' => true,
        'nickname' => true,
        'participate_cnt' => true,
        'auth_name' => true,
        'last_login' => true,
        'version' => true,
        'created' => true,
        'created_by' => true,
        'updated' => true,
        'updated_by' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected $_hidden = [
        'password',
    ];

    /**
     * 最終ログイン日更新
     */
    public function login():void {
        $this->last_login = new FrozenTime();
        $this->updateWhoColumn($this->account);
    }

    /**
     * パスワード変更
     * @param string $password パスワード（ハッシュ化前の値）
     * @param string $account 更新者のアカウント名
     */
    public function changePassword(string $password, ?string $account = null):void {
        $this->password = hash('sha256', $password);
        $this->updateWhoColumn(is_null($account) ? $this->account : $account);
    }

    /**
     * ユーザ情報更新
     * @param string $account 更新者のアカウント名
     * @param string $nickname ニックネーム
     * @param string $auth_name 権限名
     */
    public function edit(string $account, string $nickname, ?string $auth_name = null) {
        $this->nickname = $nickname;
        if (!is_null($auth_name)) {
            $this->auth_name = $auth_name;
        }        
        $this->updateWhoColumn($account);
    }
}
