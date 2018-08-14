<?php

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Cake\I18n\I18n;

/**
 * Class TagsTable
 *
 * @package App\Model\Table
 */
class TagsTable extends CommonTable
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

        $this->setTable(TABLE_PREFIX . 'tags');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addAssociations([
            'hasMany' => ['NewTags'],
        ]);

        $this->addBehavior('Translate', ['fields' => ['name']]);
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
            ->scalar('slug')
            ->requirePresence('slug', 'create')
            ->notEmpty('slug');

        $validator
            ->boolean('status')
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
        $rules->add($rules->isUnique(['name']));
        $rules->add($rules->isUnique(['slug']));

        return $rules;
    }

    /**
     * Get tag by New ID
     *
     * @param       $id
     * @param bool  $list
     * @param array $fields
     *
     * @return array
     */
    public function getTagByNewID($id, $list = false, $fields = [])
    {
        $matching = $this->association('NewTags')->find()
            ->select(['tag_id'])
            ->distinct()
            ->where(['new_id' => $id]);

        if ($list === true) {
            $fields = array_merge([
                'keyField'   => 'id',
                'valueField' => 'name',
            ], $fields);

            return $this->find('list', $fields)->enableHydration(false)
                ->where(['Tags.id IN' => $matching, 'status' => ACTIVE])
                ->toArray();
        }

        return $this->find()->select($fields)->enableHydration(false)
            ->where(['Tags.id IN' => $matching, 'status' => ACTIVE])->toArray();
    }

    /**
     * @param array $tags
     *
     * @return array
     */
    public function getOrInsertTag($tags = [])
    {
        $result = [];
        if ( ! empty($tags)) {
            foreach ($tags as $tag) {
                if (is_numeric($tag)) {
                    // if tag is integer then id already exist
                    $result[] = $tag;
                } else if ( ! empty($tag) && is_string($tag)) {
                    $data = [
                        'name'   => $tag,
                        'slug'   => $this->convertToSlug($tag),
                        'status' => ACTIVE,
                    ];

                    // create new tag
                    $tagObj   = $this->newEntity();
                    $dataTag  = $this->patchEntity($tagObj, $data);

                    $response = $this->save($dataTag);
                    if ($response) {
                        $result[] = $response->id;
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Get news by tag ID
     *
     * @param       $id
     *
     * @return array
     */
    public function getNewByTagID($id)
    {
        return $this->association('NewTags')->find()
            ->select(['new_id'])
            ->distinct()
            ->where(['tag_id' => $id]);
    }

    /**
     * Get data for menu
     */
    public function getListTag()
    {
        return $this->find()->select(['id', 'name', 'slug'])
            ->enableHydration(false)
            ->where(['status' => ACTIVE])->toArray();
    }
}
