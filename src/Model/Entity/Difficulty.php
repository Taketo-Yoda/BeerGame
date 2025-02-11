<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Difficulty Entity
 *
 * @property string $name
 * @property int $default_num_of_turn
 * @property int $display_seq
 * @property string|null $description
 * @property int $version
 * @property \Cake\I18n\FrozenTime $created
 * @property string $created_by
 * @property \Cake\I18n\FrozenTime $updated
 * @property string $updated_by
 */
class Difficulty extends Entity
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
        'default_num_of_turn' => true,
        'display_seq' => true,
        'description' => true,
        'version' => true,
        'created' => true,
        'created_by' => true,
        'updated' => true,
        'updated_by' => true,
    ];
}
