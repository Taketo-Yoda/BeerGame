<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\I18n\FrozenTime;

/**
 * Abstract Entity
 *
 * @property int $version
 * @property \Cake\I18n\FrozenTime $created
 * @property string $created_by
 * @property \Cake\I18n\FrozenTime $updated
 * @property string $updated_by
 */
abstract class AbstractEntity extends Entity
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
        'version' => true,
        'created' => true,
        'created_by' => true,
        'updated' => true,
        'updated_by' => true,
    ];

    public function initializeWhoColumn(string $account):void
    {
        $this->version = 0;
        $this->created = new FrozenTime();
        $this->created_by = $account;
        $this->updated = new FrozenTime();
        $this->updated_by = $account;
    }

    public function updateWhoColumn(string $updated_by):void {
        $this->version = $this->version + 1;
        $this->updated = new FrozenTime();
        $this->updated_by = $updated_by;
    }
}
