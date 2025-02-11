<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RoomStatus Model
 *
 * @method \App\Model\Entity\RoomStatus newEmptyEntity()
 * @method \App\Model\Entity\RoomStatus newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\RoomStatus[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RoomStatus get($primaryKey, $options = [])
 * @method \App\Model\Entity\RoomStatus findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\RoomStatus patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RoomStatus[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\RoomStatus|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RoomStatus saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RoomStatus[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\RoomStatus[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\RoomStatus[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\RoomStatus[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RoomStatusTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('room_status');
        $this->setDisplayField('name');
        $this->setPrimaryKey('name');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->boolean('display_flg')
            ->requirePresence('display_flg', 'create')
            ->notEmptyString('display_flg');

        $validator
            ->boolean('entry_flg')
            ->requirePresence('entry_flg', 'create')
            ->notEmptyString('entry_flg');

        $validator
            ->boolean('watching_flg')
            ->requirePresence('watching_flg', 'create')
            ->notEmptyString('watching_flg');

        $validator
            ->scalar('description')
            ->maxLength('description', 256)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->integer('version')
            ->notEmptyString('version');

        $validator
            ->scalar('created_by')
            ->maxLength('created_by', 30)
            ->requirePresence('created_by', 'create')
            ->notEmptyString('created_by');

        $validator
            ->scalar('updated_by')
            ->maxLength('updated_by', 30)
            ->requirePresence('updated_by', 'create')
            ->notEmptyString('updated_by');

        return $validator;
    }
}
