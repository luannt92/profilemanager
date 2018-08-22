<?php

namespace App\Controller\Admin;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * Class TagsController
 *
 * @property \App\Model\Table\TagsTable $Tags
 * @package App\Controller\Admin
 */
class TagsController extends CommonController
{
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
            $conditions['Tags.name LIKE'] = '%' . trim($params['keyword'])
                . '%';
        }

        if (isset($params['status']) && is_numeric($params['status'])) {
            $conditions['Tags.status'] = trim($params['status']);
        }

        return $conditions;
    }

    /**
     * Set variable to view
     */
    protected function _setVarToView()
    {
        $status = Configure::read('system_status');

        $this->set(compact('status'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $item = $this->Tags->newEntity();
        if ($this->request->is('post')) {
            $data           = $this->request->getData();
            $data['status'] = ACTIVE;
            if ( ! empty($data['name'])) {
                $data['slug'] = $this->convertToSlug($data['name']);
            }

            $dataSave = $this->Tags->patchEntity($item, $data);
            if ($this->Tags->save($dataSave)) {
                $this->Flash->success(__(COMMON_MSG_0001));

                return $this->redirect($this->getBackLink());
            } else {
                $error = $this->_displayErrors($dataSave->getErrors());
                $this->Flash->error($error);
            }
        }

        $this->set(compact('item'));
        $this->_setVarToView();
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
        $item    = $this->Tags->get($id);
        $newTags = TableRegistry::getTableLocator()->get('NewTags');

        /* @var \App\Model\Table\TagsTable $newTags */
        if ($newTags->valueExistInTable($id, 'tag_id') === false) {
            if ($this->Tags->delete($item)) {
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
                    $item    = $this->Tags->get($id);
                    $newTags = TableRegistry::getTableLocator()->get('NewTags');

                    /* @var \App\Model\Table\TagsTable $newTags */
                    if ($newTags->valueExistInTable($id, 'tag_id')
                        === false
                    ) {
                        if ($this->Tags->delete($item)) {
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
        /* @var \App\Model\Table\MenuItemsTable $menuItemObj */
        $menuItemObj = TableRegistry::getTableLocator()->get('MenuItems');
        $menuItemObj->updateDataByType($id, TYPE_TAG, $arrParams);
//        $this->_deleteCacheData();
    }

    /**
     * save menu and check after after delete success
     *
     * @param null $id
     */
    protected function _afterDeleteSuccess($id = null)
    {
        /* @var \App\Model\Table\MenuItemsTable $menuItemObj */
        $menuItemObj = TableRegistry::getTableLocator()->get('MenuItems');
        $menuItemObj->updateDataByType($id, TYPE_TAG, [], true);
//        $this->_deleteCacheData();
    }
}
