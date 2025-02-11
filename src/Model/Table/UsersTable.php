<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('account');
        $this->setPrimaryKey('account');

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
            ->scalar('account')
            ->maxLength('account', 30)
            ->requirePresence('account', 'create')
            ->notEmptyString('account');

        $validator
            ->scalar('password')
            ->maxLength('password', 64)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        $validator
            ->scalar('nickname')
            ->maxLength('nickname', 60)
            ->requirePresence('nickname', 'create')
            ->notEmptyString('nickname');

        $validator
            ->integer('participate_cnt')
            ->notEmptyString('participate_cnt');

        $validator
            ->scalar('auth_name')
            ->maxLength('auth_name', 30)
            ->requirePresence('auth_name', 'create')
            ->notEmptyString('auth_name');

        $validator
            ->dateTime('last_login')
            ->allowEmptyDateTime('last_login');

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
