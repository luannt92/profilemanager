<?php

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * Class MenusTable
 *
 * @package App\Model\Table
 */
class MenusTable extends CommonTable
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

        $this->setTable(TABLE_PREFIX . 'menus');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Translate', ['fields' => ['name']]);

        $this->hasMany('MenuItems')
            ->setForeignKey('menu_id')
            ->setDependent(false);
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

        $validator
            ->integer('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

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

    /**
     * @param $type
     *
     * @return array
     */
    public function getMenuByType($type)
    {
        $fields     = ['id', 'name', 'type'];
        $conditions = [
            'Menus.type'   => $type,
            'Menus.status' => ACTIVE,
        ];

        return $this->find()->select($fields)
            ->hydrate(false)
            ->where($conditions)->first();

    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function getMenuData($id)
    {
        $fields     = ['id', 'name', 'type'];
        $conditions = [
            'Menus.id'     => $id,
            'Menus.status' => ACTIVE,
        ];

        return $this->find()->select($fields)
            ->contain([
                '',
            ])
            ->hydrate(false)
            ->where($conditions)->first();

    }
}
