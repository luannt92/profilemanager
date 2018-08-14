<?php

namespace App\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * Class CategoriesTable
 *
 * @property \App\Model\Table\StoreCategoriesTable $StoreCategories
 * @package App\Model\Table
 */
class CategoriesTable extends CommonTable
{
    public $selectFields
        = [
            'id',
            'name',
            'slug',
            'image',
            'description',
            'position',
            'status',
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

        $this->setTable(TABLE_PREFIX . 'categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addAssociations([
            'belongsTo' => ['Services'],
            'hasMany'   => ['StoreCategories', 'ProductCategories'],
        ]);

        $this->belongsToMany('Stores', [
            'foreignKey'       => 'category_id',
            'targetForeignKey' => 'store_id',
            'joinTable'        => TABLE_PREFIX . 'store_categories',
        ]);

        $this->belongsToMany('Products', [
            'foreignKey'       => 'category_id',
            'targetForeignKey' => 'product_id',
            'joinTable'        => TABLE_PREFIX . 'product_categories',
        ]);

        $this->addAssociations([
            'hasMany' => ['ProductCategories'],
        ]);

        $this->addBehavior('Translate', [
            'fields' => [
                'name',
                'description',
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
        $rules->add($rules->isUnique(['name']));
        $rules->add($rules->isUnique(['slug']));

        return $rules;
    }

    public function getAllCategories(
        $conditions = [],
        $orderBy = [],
        $limit = null
    ) {
        $contain = (['Stores']);

        $select     = $this->selectFields;
        $conditions = array_merge([
            'Categories.status IN' => [ACTIVE],
        ], $conditions);

        $orderBy = empty($orderBy) ? [
            'Categories.position' => 'DESC',
        ] : $orderBy;

        return $this->execute($select, $conditions, $orderBy, $limit, $contain);
    }

    public function getCategoriesProduct(
        $conditions = [],
        $orderBy = [],
        $limit = null
    ) {
        $contain = (['Product']);

        $select     = $this->selectFields;
        $conditions = array_merge([
            'Categories.status IN' => [ACTIVE],
        ], $conditions);

        $orderBy = empty($orderBy) ? [
            'Categories.position' => 'DESC',
        ] : $orderBy;

        return $this->execute($select, $conditions, $orderBy, $limit, $contain);
    }

    public function getStoreByCategory(
        $conditions = []
    ) {
        $storeHours = Configure::read('store_hour');
        $day        = date('l');
        $contain    = ([
            'Stores',
            'Stores.Categories',
            'Stores.StoreHours' => [
                'conditions' => ['StoreHours.day' => $storeHours[$day]],
            ],
        ]);

        $select     = $this->selectFields;
        $conditions = array_merge([
            'Categories.status IN' => [ACTIVE],
        ], $conditions);

        return $this->find()
            ->select($select)
            ->enableHydration(false)
            ->where($conditions)
            ->contain($contain)
            ->firstOrFail();
    }

    /**
     * Get list categories with id and name
     *
     * @param       $fields
     * @param array $conditions
     *
     * @return array
     */
    public function getListCategories($fields, $conditions = [])
    {
        $conditions = array_merge(['status' => ENABLED,], $conditions);
        $fields     = array_merge([
            'keyField'   => 'id',
            'valueField' => 'name',
        ], $fields);

        return $this->find('list', $fields)->enableHydration(false)
            ->where($conditions)->toArray();
    }

    /**
     * @param array $categories
     * @param null  $storeId
     *
     * @return array
     */
    public function getOrInsertCategories($categories = [], $storeId = null)
    {
        $result = [];
        if ( ! empty($categories)) {
            foreach ($categories as $category) {
                if (is_numeric($category)) {
                    // if category is integer then id already exist
                    $result[] = $category;
                } else if ( ! empty($category) && is_string($category)) {
                    $data = [
                        'name'   => $category,
                        'slug'   => $this->convertToSlug($category),
                        'status' => ACTIVE,
                    ];

                    // create new categories
                    $categoriesObj = $this->newEntity();
                    $dataCategory  = $this->patchEntity($categoriesObj, $data);

                    $response = $this->save($dataCategory);
                    if ($response) {
                        $result[] = $response->id;

                        if ( ! empty($storeId)) {
                            $dataStore = [
                                'store_id'    => $storeId,
                                'category_id' => $response->id,
                                'status'      => ACTIVE,
                            ];
                            // create new store categories
                            $storeCategoriesObj
                                = $this->StoreCategories->newEntity();
                            $dataStoreCategory
                                = $this->StoreCategories->patchEntity($storeCategoriesObj,
                                $dataStore);
                            $this->StoreCategories->save($dataStoreCategory);
                        }
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Get list category by service id
     *
     * @param       $serviceId
     *
     * @return array
     */
    public function getListByService($serviceId)
    {
        $result = $this->find('list')
            ->where([
                'status' => ACTIVE,
                'OR'     => [
                    'service_id' => $serviceId,
                    'service_id IS NULL',
                ],
            ])
            ->toArray();

        return $result;
    }

    /**
     * Get category by store
     *
     * @param       $id
     * @param bool  $list
     * @param array $fields
     * @param bool  $flag
     *
     * @return array
     */
    public function getCategoryByStore(
        $id,
        $list = false,
        $fields = [],
        $flag = true
    ) {
        $matching = $this->association('StoreCategories')->find()
            ->select(['category_id'])
            ->distinct()
            ->where(['store_id' => $id, 'status' => ACTIVE]);

        if ($list === true) {
            $fields = array_merge([
                'keyField'   => 'id',
                'valueField' => 'name',
            ], $fields);

            if ($flag) {
                $conditions = [
                    'OR'     => [
                        ['Categories.id IN' => $matching],
                        ['Categories.service_id IS NULL'],
                    ],
                    'status' => ACTIVE,
                ];
            } else {
                $conditions = [
                    'Categories.id IN' => $matching,
                    'status'           => ACTIVE,
                ];
            }

            return $this->find('list', $fields)->enableHydration(false)
                ->where($conditions)
                ->toArray();
        }

        return $this->find()->select($fields)->enableHydration(false)
            ->where(['Categories.id IN' => $matching, 'status' => ACTIVE])
            ->toArray();
    }

    /**
     * Get category by product
     *
     * @param       $id
     * @param bool  $list
     * @param array $fields
     *
     * @return array
     */
    public function getCategoryByProduct($id, $list = false, $fields = [])
    {
        $matching = $this->association('ProductCategories')->find()
            ->select(['category_id'])
            ->distinct()
            ->where(['product_id' => $id, 'status' => ACTIVE]);

        if ($list === true) {
            $fields = array_merge([
                'keyField'   => 'id',
                'valueField' => 'name',
            ], $fields);

            return $this->find('list', $fields)->enableHydration(false)
                ->where(['Categories.id IN' => $matching, 'status' => ACTIVE])
                ->toArray();
        }

        return $this->find()->select($fields)->enableHydration(false)
            ->where(['Categories.id IN' => $matching, 'status' => ACTIVE])
            ->toArray();
    }

    /**
     * Get data for menu
     */
    public function getListCategory()
    {
        return $this->find()->select(['id', 'name', 'slug'])
            ->enableHydration(false)
            ->where(['status' => ACTIVE])->toArray();
    }

    public function getProductByCategory(
        $conditions = [],
        $store
    ) {
        $today   = date('Y-m-d H:i:s', time());
        $contain = ([
            'Products'                                          => [
                'conditions'   => ['Products.store_id' => $store],
                'queryBuilder' => function ($q) {
                    return $q->order(['Products.position' => 'DESC']);
                },
            ],
            'Products.ProductAttributes'                        => [
                'fields' => [
                    'ProductAttributes.id',
                    'ProductAttributes.product_id',
                    'ProductAttributes.name',
                    'ProductAttributes.position',
                    'ProductAttributes.type',
                    'ProductAttributes.status',
                ],
            ],
            'Products.ProductAttributes.ProductAttributeValues' => [
                'fields' => [
                    'ProductAttributeValues.id',
                    'ProductAttributeValues.product_attribute_id',
                    'ProductAttributeValues.name',
                    'ProductAttributeValues.price',
                    'ProductAttributeValues.status',
                ],
            ],
            'Products.ProductDiscounts'                         => [
                'fields'     => [
                    'ProductDiscounts.id',
                    'ProductDiscounts.product_id',
                    'ProductDiscounts.start_date',
                    'ProductDiscounts.end_date',
                    'ProductDiscounts.percent',
                ],
                'conditions' => [
                    'ProductDiscounts.start_date <=' => $today,
                    'ProductDiscounts.end_date >='   => $today,
                ],
            ],
        ]);

        $select     = $this->selectFields;
        $conditions = array_merge([
            'Categories.status IN' => [ACTIVE],
        ], $conditions);

        return $this->find()
            ->select($select)
            ->enableHydration(false)
            ->where($conditions)
            ->contain($contain)
            ->firstOrFail();
    }

    public function getCategoriesByProductId(
        $productID,
        $store_id,
        $limit = null
    ) {
        $conditions = ['product_id' => $productID];
        if (is_array($productID)) {
            $conditions = ['product_id IN' => $productID];
        }

        $matching             = $this->association('ProductCategories')->find()
            ->select(['category_id'])
            ->distinct()
            ->where($conditions);
        $select               = $this->selectFields;
        $CategoriesConditions = [
            'Categories.status' => ACTIVE,
            'Categories.id IN'  => $matching,
        ];

        $orderBy = [
            'Categories.position' => 'DESC',
        ];

        $contain
            = ['Products' => ['conditions' => ['Products.store_id' => $store_id]]];

        return $this->execute($select, $CategoriesConditions, $orderBy, $limit,
            $contain);
    }

    public function getCategoriesByStoreId($storeID, $limit = null)
    {
        $conditions = ['store_id' => $storeID];
        if (is_array($storeID)) {
            $conditions = ['store_id IN' => $storeID];
        }

        $matching = $this->association('StoreCategories')->find()
            ->select(['category_id'])
            ->distinct()
            ->where($conditions);

        $select               = $this->selectFields;
        $CategoriesConditions = [
            'Categories.status' => ACTIVE,
            'Categories.id IN'  => $matching,
        ];

        $orderBy = [
            'Categories.position' => 'DESC',
        ];

        $contain = ['Stores'];

        return $this->execute($select, $CategoriesConditions, $orderBy, $limit,
            $contain);
    }
}
