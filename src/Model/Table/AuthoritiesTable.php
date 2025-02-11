<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Authorities Model
 *
 * @method \App\Model\Entity\Authority newEmptyEntity()
 * @method \App\Model\Entity\Authority newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Authority[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Authority get($primaryKey, $options = [])
 * @method \App\Model\Entity\Authority findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Authority patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Authority[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Authority|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Authority saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Authority[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Authority[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Authority[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Authority[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AuthoritiesTable extends Table
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

        $this->setTable('authorities');
        $this->setDisplayField('auth_name');
        $this->setPrimaryKey('auth_name');

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
