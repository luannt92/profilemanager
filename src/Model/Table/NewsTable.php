<?php

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * Class NewsTable
 *
 * @property \App\Model\Table\NewCategoriesTable $NewCategories
 * @property \App\Model\Table\TagsTable $Tags
 * @package App\Model\Table
 */
class NewsTable extends CommonTable
{
    /* set fields default */
    public $selectFields
        = [
            'id',
            'title',
            'slug',
            'description',
            'publish_date',
            'meta_title',
            'meta_description',
            'meta_keyword',
            'image',
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

        $this->setTable(TABLE_PREFIX . 'news');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType'   => 'INNER',
        ]);

        $this->belongsTo('NewCategories', [
            'foreignKey' => 'new_category_id',
            'joinType'   => 'INNER',
        ]);

        $this->belongsToMany('Tags', [
            'foreignKey'       => 'new_id',
            'targetForeignKey' => 'tag_id',
            'joinTable'        => TABLE_PREFIX . 'new_tags',
        ]);

        $this->addAssociations([
            'hasMany' => ['NewTags'],
        ]);

        $this->addBehavior('Translate', [
            'fields' => [
                'title',
                'description',
                'content',
                'meta_title',
                'meta_description',
                'meta_keyword',
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
            ->scalar('new_category_id')
            ->notEmpty('new_category_id');

        $validator
            ->scalar('slug')
            ->requirePresence('slug', 'create')
            ->notEmpty('slug');

        $validator
            ->scalar('description')
            ->allowEmpty('description');

        $validator
            ->scalar('image')
            ->allowEmpty('image');

        $validator
            ->scalar('meta_title')
            ->allowEmpty('meta_title');

        $validator
            ->scalar('meta_description')
            ->allowEmpty('meta_description');

        $validator
            ->scalar('meta_keyword')
            ->allowEmpty('meta_keyword');

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

    /**
     * @param array $conditions
     * @param array $orderBy
     * @param int   $limit
     *
     * @return array
     */
    public function getAll(
        $conditions = [],
        $orderBy = [],
        $limit = 4
    ) {
        $select     = $this->selectFields;
        $conditions = array_merge([
            'News.status IN'       => [ACTIVE],
            'News.publish_date <=' => date('Y-m-d H:i:s'),
        ], $conditions);

        $orderBy = empty($orderBy) ? [
            'News.publish_date' => 'DESC',
        ] : $orderBy;

        return $this->execute($select, $conditions, $orderBy, $limit);
    }

    /**
     * @param       $id
     * @param       $tagID
     * @param int   $limit
     *
     * @return array
     */
    public function getNewsByTagsID($id, $tagID, $limit = 20)
    {
        $conditions = ['tag_id' => $tagID];
        if (is_array($tagID)) {
            $conditions = ['tag_id IN' => $tagID];
        }

        $matching = $this->association('NewTags')->find()
            ->select(['new_id'])
            ->distinct()
            ->where($conditions);

        $select        = $this->selectFields;
        $newConditions = [
            'News.status IN'       => [ACTIVE],
            'News.id IN'           => $matching,
            'News.id !='           => $id,
            'News.publish_date <=' => date('Y-m-d H:i:s'),
        ];

        $orderBy = [
            'News.publish_date' => 'DESC',
        ];

        return $this->execute($select, $newConditions, $orderBy, $limit);
    }

    /**
     * @param array $conditions
     * @param bool  $list
     * @param array $fields
     * @param array $order
     * @param null  $limit
     *
     * @return array
     */
    public function getNews(
        $conditions = [],
        $list = false,
        $fields = [],
        $order = [],
        $limit = null
    ) {
        $conditions = array_merge(['status' => ACTIVE], $conditions);

        $query = $list === false ? $this->find()->select($fields)
            : $this->find('list', $fields);

        if ( ! empty($limit)) {
            $query->limit($limit);
        }

        return $query->where($conditions)->order($order)->toArray();
    }
}
