<?php

namespace App\Controller\Admin;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * Class CategoriesController
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 * @property \App\Model\Table\ServicesTable   $Services
 * @package App\Controller\Admin
 */
class CategoriesController extends CommonController
{
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * Index method
     *
     * @param array $conditions
     */
    public function index($conditions = [])
    {
        $this->setReturnUrl();

        $defaultStatus = [ENABLED, DISABLED];
        $search        = $this->request->getQueryParams();
        if (isset($search['status']) && is_numeric($search['status'])) {
            $defaultStatus = $search['status'];
        }
        $conditions = [
            'Categories.status IN' => $defaultStatus,
        ];
        $conditions = $this->_searchFiltersCondition($conditions, $search);

        $this->paginate = [
            'contain'    => [
                'Services' => ['fields' => ['id', 'name']],
            ],
            'conditions' => $conditions,
            'order'      => [
                'Categories.id' => 'DESC',
            ],
        ];
        $items          = $this->paginate($this->Categories);

        $this->set(compact('items', 'search'));
        $this->_setVarToView();
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
            $conditions['Categories.name LIKE'] = '%' . trim($params['keyword'])
                . '%';
        }

        if (isset($params['status']) && is_numeric($params['status'])) {
            $conditions['Categories.status'] = trim($params['status']);
        }

        return $conditions;
    }

    /**
     * Set variable to view
     */
    protected function _setVarToView()
    {
        $categories = $this->Categories->find('list');
        $status     = Configure::read('system_status');
        $this->loadModel('Services');
        $services = $this->Services->find('list')
            ->where(['status' => ACTIVE]);

        $this->set(compact('categories', 'status', 'services'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $item = $this->Categories->newEntity();

        if ($this->request->is('post')) {
            $data           = $this->request->getData();
            $data['status'] = ACTIVE;
            if ( ! empty($data['name'])) {
                $data['slug'] = $this->convertToSlug($data['name']);
            }
            $item = $this->Categories->patchEntity($item, $data);

            if ($this->Categories->save($item)) {
                $this->Flash->success(__(COMMON_MSG_0001));

                return $this->redirect($this->getBackLink());
            } else {
                $error = $this->_displayErrors($item->getErrors());
                $this->Flash->error($error);
            }
        }

        $categories = $this->Categories->find('list')
            ->where(['status' => ACTIVE]);

        $this->loadModel('Services');
        $services = $this->Services->find('list')
            ->where(['status' => ACTIVE]);

        $this->set(compact('item', 'categories', 'services'));
    }

    /**
     * Edit method
     *
     * @param string|null $id $modelAlias id.
     *
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $item = $this->Categories->get($id, [
            'finder'  => 'translations',
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data     = $this->request->getData();
            $dataSave = $this->Categories->patchEntity($item, $data);

            if ($this->Categories->save($dataSave)) {
                $this->Flash->success(__(COMMON_MSG_0001));

                return $this->redirect($this->getBackLink());
            } else {
                $error = $this->_displayErrors($dataSave->getErrors());
                $this->Flash->error($error);
            }
        }

        $categories = $this->Categories->find('list')->where([
            'Categories.id !=' => $id,
            'status'           => ACTIVE,
        ]);

        $this->loadModel('Services');
        $services = $this->Services->find('list')
            ->where(['status' => ACTIVE]);

        $this->set(compact('item', 'categories', 'services'));
    }

    /**
     * Delete method
     *
     * @param string|null $id $modelAlias id.
     *
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $item              = $this->Categories->get($id);
        $productCategories = TableRegistry::getTableLocator()
            ->get('ProductCategories');

        /* @var \App\Model\Table\CategoriesTable $productCategories */
        if ($productCategories->valueExistInTable($id, 'category_id')
            === false
        ) {
            if ($this->Categories->delete($item)) {
//                $this->_afterDeleteSuccess($id);
                $this->Flash->success(__(COMMON_MSG_0003, h($id)));
            } else {
                $this->Flash->error(__(COMMON_MSG_0004));
            }
        } else {
            $this->Flash->error(__(COMMON_MSG_0004));
        }

        return $this->redirect($this->getBackLink());
    }

    /**
     * Delete selected
     *
     * @return \Cake\Http\Response|null
     */
    public function deleteSelected()
    {
        if ($this->request->is('post')) {
            $listId = $this->request->getData('selectedAll');
            if ( ! empty($listId)) {
                $listId = explode(",", $listId);
                foreach ($listId as $id) {
                    $item          = $this->Categories->get($id);
                    $newCategories = TableRegistry::getTableLocator()
                        ->get('NewCategories');

                    /* @var \App\Model\Table\CategoriesTable $newCategories */
                    if ($newCategories->valueExistInTable($id, 'category_id')
                        === false
                    ) {
                        if ($this->Categories->delete($item)) {
//                            $this->_afterDeleteSuccess($id);
                            $this->Flash->success(__(COMMON_MSG_0003, h($id)));
                        } else {
                            $this->Flash->error(__(COMMON_MSG_0004));
                        }
                    } else {
                        $this->Flash->error(__(COMMON_MSG_0004));
                    }
                }
            }

            return $this->redirect($this->getBackLink());
        }
    }

    /**
     * save menu and check after after edit success
     *
     * @param null  $id
     * @param array $arrParams
     */
    protected function _afterUpdateSuccess($id = null, $arrParams = [])
    {
        $menuItemObj = TableRegistry::getTableLocator()->get('MenuItems');
        /* @var \App\Model\Table\MenuItemsTable $menuItemObj */
        $menuItemObj->updateDataByType($id, TYPE_CATEGORY, $arrParams);
//        $this->_deleteCacheData();
    }

    /**
     * save menu and check after after delete success
     *
     * @param null $id
     */
    protected function _afterDeleteSuccess($id = null)
    {
        $menuItemObj = TableRegistry::getTableLocator()->get('MenuItems');
        /* @var \App\Model\Table\MenuItemsTable $menuItemObj */
        $menuItemObj->updateDataByType($id, TYPE_CATEGORY, [], true);
//        $this->_deleteCacheData();
    }
}
