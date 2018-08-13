<?php

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * Class PagesTable
 *
 * @package App\Model\Table
 */
class PagesTable extends CommonTable
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

        $this->setTable(TABLE_PREFIX . 'pages');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType'   => 'INNER',
        ]);

        $this->addBehavior('Translate', [
            'fields' => [
                'title',
                'description',
                'content',
                'seo_title',
                'seo_description',
                'seo_keyword',
            ],
        ]);
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
            ->integer('user_id')
            ->notEmpty('user_id');

        $validator
            ->scalar('title')
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->scalar('description')
            ->allowEmpty('description', 'create');

        $validator
            ->scalar('content')
            ->allowEmpty('content', 'create');

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
        $rules->add($rules->isUnique(['slug']));

        return $rules;
    }

    public function checkType($type = null, $id = null)
    {
        $check = $this->find()
            ->where(['Pages.type' => $type, 'Pages.status' => ACTIVE, 'Pages.id !=' => $id])
            ->first();
        if (empty($check)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get data for menu
     */
    public function getListPage()
    {
        return $this->find()->select(['id', 'title', 'slug'])->enableHydration(false)
            ->where(['Pages.status' => ACTIVE])->toArray();
    }

}
