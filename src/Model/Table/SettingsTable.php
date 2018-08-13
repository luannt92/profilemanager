<?php

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * Class SettingsTable
 *
 * @package App\Model\Table
 */
class SettingsTable extends CommonTable
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

        $this->setTable(TABLE_PREFIX . 'settings');
        $this->setDisplayField('name');
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
            ->scalar('name')
            ->requirePresence('name', 'create')
            ->notEmpty('name');

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
        $rules->add($rules->isUnique(['name']));

        return $rules;
    }

    /**
     * Get list setting with id and name
     *
     * @param       $fields
     * @param array $conditions
     *
     * @return array
     */
    public function getListSetting($fields, $conditions = [])
    {
        $conditions = array_merge(['status' => ENABLED,], $conditions);
        $fields     = array_merge([
            'keyField'   => 'name',
            'valueField' => 'value',
        ], $fields);

        return $this->find('list', $fields)->hydrate(false)
            ->where($conditions)->toArray();
    }
}
