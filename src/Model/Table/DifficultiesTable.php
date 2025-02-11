<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Difficulties Model
 *
 * @method \App\Model\Entity\Difficulty newEmptyEntity()
 * @method \App\Model\Entity\Difficulty newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Difficulty[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Difficulty get($primaryKey, $options = [])
 * @method \App\Model\Entity\Difficulty findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Difficulty patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Difficulty[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Difficulty|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Difficulty saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Difficulty[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Difficulty[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Difficulty[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Difficulty[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DifficultiesTable extends Table
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

        $this->setTable('difficulties');
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
            ->integer('default_num_of_turn')
            ->requirePresence('default_num_of_turn', 'create')
            ->notEmptyString('default_num_of_turn');

        $validator
            ->integer('display_seq')
            ->requirePresence('display_seq', 'create')
            ->notEmptyString('display_seq');

        $validator
            ->scalar('description')
            ->maxLength('description', 256)
            ->allowEmptyString('description');

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
