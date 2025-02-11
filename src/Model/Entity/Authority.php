<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Authority Entity
 *
 * @property string $auth_name
 * @property string $description
 * @property int $version
 * @property \Cake\I18n\FrozenTime $created
 * @property string $created_by
 * @property \Cake\I18n\FrozenTime $updated
 * @property string $updated_by
 */
class Authority extends Entity
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
        'description' => true,
        'version' => true,
        'created' => true,
        'created_by' => true,
        'updated' => true,
        'updated_by' => true,
    ];
}
