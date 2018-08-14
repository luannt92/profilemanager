<?php

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * Class SlidersTable
 *
 * @package App\Model\Table
 */
class SlidersTable extends CommonTable
{
    public $selectFields
        = [
            'id',
            'image',
            'title',
            'url',
            'position',
            'status',
            'type',
            'language',
        ];
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

        $this->setTable(TABLE_PREFIX . 'sliders');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Translate', [
            'fields' => [
                'title',
                'description',
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
            ->scalar('title')
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->scalar('image')
            ->notEmpty('image');

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
        $rules->add($rules->isUnique(['title']));

        return $rules;
    }

    /**
     * @param array $conditions
     * @param array $orderBy
     * @param int   $limit
     *
     * @return array
     */
    public function getAllSliders(
        $conditions = [],
        $orderBy = [],
        $limit = 5
    ) {
        $select     = $this->selectFields;
        $conditions = array_merge([
            'Sliders.status IN' => [ACTIVE],
        ], $conditions);

        $orderBy = empty($orderBy) ? [
            'Sliders.position' => 'DESC',
        ] : $orderBy;

        return $this->execute($select, $conditions, $orderBy, $limit);
    }
}
