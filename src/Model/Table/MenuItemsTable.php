<?php

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Cake\Routing\Router;

/**
 * Class MenuItemsTable
 *
 * @package App\Model\Table
 */
class MenuItemsTable extends CommonTable
{
    /* set fields default */
    public $selectFields
        = [
            'id',
            'menu_id',
            'name',
            'url',
            'type',
            'obj_id',
            'target',
            'position',
            'parent_id'
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

        $this->setTable(TABLE_PREFIX . 'menu_items');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Menus', [
            'foreignKey' => 'menu_id',
            'joinType'   => 'INNER',
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
     * Get items of menu
     *
     * @param $menuId
     *
     * @return array
     */
    public function getMenuByType($menuId)
    {
        return $this->find('threaded', [
            'keyField'    => 'id',
            'parentField' => 'parent_id',
        ])->select($this->selectFields)->find('translations')
            ->enableHydration(false)
            ->where(['MenuItems.menu_id' => $menuId])
            ->order([
                'position' => 'ASC',
            ])->toArray();
    }

    /**
     * @param      $id
     * @param      $type
     * @param      $arrParams
     * @param bool $delete
     *
     * @return bool
     */
    public function updateDataByType($id, $type, $arrParams, $delete = false)
    {
        $item = $this->find()->where([
            'MenuItems.obj_id' => $id,
            'MenuItems.type'   => $type,
        ])->contain(['Menus'])->first();

        if ( ! empty($item)) {
            if ($delete) {
                return $this->delete($item) ? true : false;
            } else {
                if ( ! empty($arrParams['slug'])) {
                    $option    = ! empty($item->menu->type)
                        && $item->menu->type === MENU;
                    $item->url = Router::url('/', true) . $option . '/'
                        . $arrParams['slug'];
                }

                if ( ! empty($arrParams['name'])) {
                    $item->name = $arrParams['name'];
                }

                return $this->save($item) ? true : false;
            }
        }
    }

    /**
     * get all id by id menu
     * @param null $id
     *
     * @return array
     */
    public function getIdByMenu($id = null)
    {
        return $this->find()->select(['id'])->where(['menu_id' => $id])
            ->toArray();
    }
}
