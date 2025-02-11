<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RoomChat Model
 *
 * @property \App\Model\Table\RoomsTable&\Cake\ORM\Association\BelongsTo $Rooms
 *
 * @method \App\Model\Entity\RoomChat newEmptyEntity()
 * @method \App\Model\Entity\RoomChat newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\RoomChat[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RoomChat get($primaryKey, $options = [])
 * @method \App\Model\Entity\RoomChat findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\RoomChat patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RoomChat[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\RoomChat|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RoomChat saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RoomChat[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\RoomChat[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\RoomChat[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\RoomChat[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RoomChatTable extends Table
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

        $this->setTable('room_chat');
        $this->setDisplayField(['room_id', 'posted_datetime', 'account']);

        $this->addBehavior('Timestamp');

        $this->belongsTo('Rooms', [
            'foreignKey' => 'room_id',
            'joinType' => 'INNER',
        ]);
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
            ->integer('room_id')
            ->requirePresence('room_id', 'create')
            ->notEmptyString('room_id');

        $validator
            ->dateTime('posted_datetime')
            ->notEmptyDateTime('posted_datetime');

        $validator
            ->scalar('account')
            ->maxLength('account', 30)
            ->allowEmptyString('account');

        $validator
            ->scalar('message')
            ->maxLength('message', 256)
            ->requirePresence('message', 'create')
            ->notEmptyString('message');

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

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('room_id', 'Rooms'), ['errorField' => 'room_id']);

        return $rules;
    }
}
