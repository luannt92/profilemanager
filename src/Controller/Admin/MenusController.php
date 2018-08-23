<?php

namespace App\Controller\Admin;

use Cake\Cache\Cache;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

/**
 * Class MenusController
 *
 * @package App\Controller\Admin
 */
class MenusController extends CommonController
{
    /* Allow action */
    protected $_allowAction = ['index', 'edit', 'add'];

    public function initialize()
    {
        parent::initialize();
    }

    /**
     * Search with filter conditions
     *
     * @param $conditions
     * @param $params
     *
     * @return mixed
     */
    protected function _searchFiltersCondition($conditions, $params = [])
    {
        if ( ! empty($params['keyword'])) {
            $conditions['Menus.name LIKE'] = '%' . trim($params['keyword'])
                . '%';
        }

        if (isset($params['status']) && is_numeric($params['status'])) {
            $conditions['Menus.status'] = trim($params['status']);
        }

        return $conditions;
    }

    /**
     * Set variable to view
     */
    protected function _setVarToView()
    {
        $status   = Configure::read('system_status');
        $typeMenu = Configure::read('type_menu');

        $this->set(compact('status', 'typeMenu'));
    }

    /**
     * @param null $id
     *
     * @return \Cake\Http\Response|null
     */
    public function edit($id = null)
    {
        $menuCheck     = $this->Menus->findById($id)->firstOrFail();
        $menuCheckType = ! empty($menuCheck['type']) ? $menuCheck['type']
            : MENU;
        $icons         = Configure::read('icon_menu_child');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            if ( ! empty($data['menu'])) {
                $menuData = json_decode($data['menu']);
                if ( ! empty($menuData) && $this->_saveData($menuData, $id)) {
                    $this->Flash->success(__(COMMON_MSG_0001));

                    return $this->redirect($this->getBackLink());
                }
            }
            $this->Flash->error(__(COMMON_MSG_0002));
        }

        $categories    = TableRegistry::getTableLocator()->get('Categories');
        $newCategories = TableRegistry::getTableLocator()->get('NewCategories');
        $pages         = TableRegistry::getTableLocator()->get('Pages');
        $menuItemObj   = TableRegistry::getTableLocator()->get('MenuItems');

        /* @var \App\Model\Table\CategoriesTable $categories */
        /* @var \App\Model\Table\NewCategoriesTable $newCategories */
        /* @var \App\Model\Table\TagsTable $tags */
        /* @var \App\Model\Table\PagesTable $pages */
        /* @var \App\Model\Table\MenuItemsTable $menuItemObj */
        $pages         = $pages->getListPage();
        $newCategories = $newCategories->getListCategory();
        $categories    = $categories->getListCategory();

        $menuTab   = $menuItemObj->getMenuByType($id);
        $languages = Configure::read('system_languages');
        $menuId    = $id;
        $this->set(compact('categories', 'menuTab', 'menuId',
            'menuCheckType', 'newCategories', 'pages', 'languages',
            'menuCheck', 'icons'));
    }

    /**
     * @param array $menuData
     * @param       $id
     *
     * @return bool
     */
    private function _saveData($menuData = [], $id)
    {
        $language    = Configure::read('system_languages');
        $flag        = false;
        $menuItemObj = TableRegistry::getTableLocator()->get('MenuItems');
        /* @var \App\Model\Table\MenuItemsTable $menuItemObj */
        $languageObj = TableRegistry::getTableLocator()->get('I18n');
        //delete all data of menu
        $idArr = $menuItemObj->getIdByMenu($id);
        $menuItemObj->deleteAll(['menu_id' => $id]);
        foreach ($idArr as $idL) {
            $languageObj->deleteAll([
                'foreign_key' => $idL->id,
                'model'       => 'MenuItems',
            ]);
        }

        // insert new data
        foreach ($menuData as $position => $menu) {
            ++$position;
            $type   = ! empty($menu->type) ? $menu->type : TYPE_LINK;
            $target = ($type === TYPE_LINK) ? ACTIVE : DEACTIVE;

            $menuItem = [
                'menu_id'   => $id,
                'obj_id'    => ! empty($menu->id) ? $menu->id : null,
                'name'      => ! empty($menu->name) ? $menu->name : 'No Name',
                'url'       => ! empty($menu->url) ? $menu->url : null,
                'type'      => $type,
                'target'    => $target,
                'position'  => $position,
                'status'    => ACTIVE,
                'parent_id' => null,
            ];

            $menuSave = $menuItemObj->newEntity($menuItem);
            foreach ($menu as $datKey => $item) {
                if (array_key_exists($datKey, $language)) {
                    $menuSave->translation($datKey)
                        ->set(['name' => $item], ['guard' => false]);
                }
            }
            if ($afterSave = $menuItemObj->save($menuSave)) {
                $flag = true;

                if ( ! empty($menu->children)) {

                    foreach ($menu->children as $key => $value) {
                        ++$key;
                        $type   = ! empty($value->type) ? $value->type
                            : TYPE_LINK;
                        $target = ($type === TYPE_LINK) ? ACTIVE : DEACTIVE;

                        $menuChildItem = [
                            'menu_id'   => $id,
                            'obj_id'    => ! empty($value->id) ? $value->id
                                : null,
                            'name'      => ! empty($value->name) ? $value->name
                                : 'No Name',
                            'url'       => ! empty($value->url) ? $value->url
                                : null,
                            'type'      => $type,
                            'target'    => $target,
                            'position'  => $key,
                            'status'    => ACTIVE,
                            'parent_id' => $afterSave->id,
                            'icon'      => ! empty($value->icon) ? $value->icon
                                : null,
                        ];

                        $menuChildSave
                            = $menuItemObj->newEntity($menuChildItem);
                        foreach ($value as $datKeyS => $items) {
                            if (array_key_exists($datKeyS, $language)) {
                                $menuChildSave->translation($datKeyS)
                                    ->set(['name' => $items],
                                        ['guard' => false]);
                            }
                        }
                        $menuItemObj->save($menuChildSave);
                    }
                }
            }
        }

        $this->_deleteCacheData();

        return $flag;
    }

    /**
     * Delete cache from menu
     */
    private function _deleteCacheData()
    {
        Cache::delete(KEY_MENU_CACHE . MENU_HEADER . '_vi');
        Cache::delete(KEY_MENU_CACHE . MENU_HEADER . '_en');
        Cache::delete(KEY_MENU_CACHE . MENU_FOOTER . '_vi');
        Cache::delete(KEY_MENU_CACHE . MENU_FOOTER . '_en');
        Cache::delete(KEY_MENU_CACHE . MENU_LINK . '_vi');
        Cache::delete(KEY_MENU_CACHE . MENU_LINK . '_en');
    }
}
