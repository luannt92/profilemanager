<?php

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * Class ContactsTable
 *
 * @package App\Model\Table
 */
class ContactsTable extends CommonTable
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     *
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable(TABLE_PREFIX . 'contacts');
        $this->setDisplayField('id');
        $this->addBehavior('Translate', []);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     *
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('customer')
            ->requirePresence('customer', 'create')
            ->notEmpty('customer');

        $validator
            ->scalar('company')
            ->allowEmpty('company');

        $validator
            ->scalar('address')
            ->allowEmpty('address');

        $validator
            ->scalar('subject')
            ->requirePresence('subject', 'create')
            ->notEmpty('subject');

        $validator
            ->scalar('content')
            ->requirePresence('content', 'create')
            ->notEmpty('content');

        $validator
            ->scalar('start_time')
            ->requirePresence('start_time', 'create')
            ->notEmpty('start_time');

        $validator
            ->scalar('send_from')
            ->requirePresence('send_from', 'create')
            ->notEmpty('send_from');

        $validator
            ->scalar('phone_number')
            ->allowEmpty('phone_number');

        $validator
            ->integer('type')
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     *
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        return $rules;
    }
}
