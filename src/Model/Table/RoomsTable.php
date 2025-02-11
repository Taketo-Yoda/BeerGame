<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Rooms Model
 *
 * @property \App\Model\Table\MembersTable&\Cake\ORM\Association\HasMany $Members
 *
 * @method \App\Model\Entity\Room newEmptyEntity()
 * @method \App\Model\Entity\Room newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Room[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Room get($primaryKey, $options = [])
 * @method \App\Model\Entity\Room findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Room patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Room[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Room|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Room saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Room[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Room[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Room[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Room[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RoomsTable extends Table
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

        $this->setTable('rooms');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('members', [
            'foreignKey' => 'room_id',
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
            ->scalar('name')
            ->maxLength('name', 30)
            ->allowEmptyString('name');

        $validator
            ->scalar('status')
            ->maxLength('status', 30)
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->scalar('difficulty')
            ->maxLength('difficulty', 30)
            ->requirePresence('difficulty', 'create')
            ->notEmptyString('difficulty');

        $validator
            ->integer('num_of_turn')
            ->requirePresence('num_of_turn', 'create')
            ->notEmptyString('num_of_turn');

        $validator
        ->integer('current_turn')
        ->requirePresence('current_turn', 'create')
        ->notEmptyString('current_turn');

        $validator
            ->dateTime('start_date')
            ->allowEmptyDateTime('start_date');

        $validator
            ->dateTime('end_date')
            ->allowEmptyDateTime('end_date');

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
