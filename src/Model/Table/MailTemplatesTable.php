<?php

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * Class MailTemplatesTable
 *
 * @package App\Model\Table
 */
class MailTemplatesTable extends CommonTable
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

        $this->setTable(TABLE_PREFIX . 'mail_templates');
        $this->setDisplayField('subject');
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
            ->scalar('subject')
            ->requirePresence('subject', 'create')
            ->notEmpty('subject');

        $validator
            ->scalar('code')
            ->notEmpty('code');

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
        $rules->add($rules->isUnique(['code']));

        return $rules;
    }

    /**
     * @param $code
     *
     * @return array|\Cake\Datasource\EntityInterface|null
     */
    public function getMailTemplate($code)
    {
        return $this->find()
            ->enableHydration(false)
            ->select(['id', 'subject', 'content'])
            ->where(['code' => $code])
            ->first();
    }
}
