<?php

namespace App\Controller\Admin;

use Cake\Cache\Cache;
use \Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * Class UserGroupsController
 *
 * @property \App\Model\Table\UserGroupsTable $UserGroups
 * @package App\Controller\Admin
 */
class UserGroupsController extends CommonController
{
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * @param       $conditions
     * @param array $params
     *
     * @return mixed
     */
    protected function _searchFiltersCondition($conditions, $params = [])
    {
        if ( ! empty($params['keyword'])) {
            $keyword      = trim($params['keyword']);
            $conditions[] = [
                'OR' => [
                    'UserGroups.name LIKE' => '%' . $keyword . '%',
                    'UserGroups.id LIKE'   => $keyword,
                ],
            ];
        }

        if (isset($params['status']) && is_numeric($params['status'])) {
            $conditions['UserGroups.status'] = trim($params['status']);
        }

        return $conditions;
    }

    /**
     * Set variable to view
     */
    protected function _setVarToView()
    {
        $status      = Configure::read('system_status');
        $types       = Configure::read('group_types');
        $permissions = Configure::read('permissions');

        $this->set(compact('status', 'types', 'permissions'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $item = $this->UserGroups->newEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['status'] = ! empty($data['status']) ? $data['status']
                : ENABLED;
            $dataSave = $this->UserGroups->patchEntity($item, $data);
            if ($groupInfo = $this->UserGroups->save($dataSave)) {

                if ( ! empty($data['access']) && $data['type'] != ADMIN) {
                    $permission = [];
                    $current    = date('Y-m-d H:i:s');
                    $groupId    = $groupInfo->id;
                    foreach ($data['access'] as $code => $checked) {
                        if ($checked) {
                            $permission[] = [
                                'user_group_id' => $groupId,
                                'code'          => $code,
                                'created_at'    => $current,
                                'updated_at'    => $current,
                            ];
                        }
                    }

                    $userGroupPermissions = TableRegistry::get('UserGroupPermissions');
                    $entities = $userGroupPermissions->newEntities($permission);
                    $userGroupPermissions->saveMany($entities);
                }

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
     * Edit method
     *
     * @param string|null $id $modelAlias id.
     *
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $item = $this->UserGroups->get($id, [
            'finder'  => 'translations',
            'contain' => [],
        ]);

        $userGroupPermissions = TableRegistry::get('UserGroupPermissions');
        $listPermissions = $userGroupPermissions->getListPermission($id);
        $accessArr = [];
        foreach ($listPermissions as $code) {
            $accessArr[$code] = ENABLED;
        }
        $item->access = $accessArr;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            $dataSave = $this->UserGroups->patchEntity($item, $data);
            if ($this->UserGroups->save($dataSave)) {

                if ( ! empty($data['access']) && $data['type'] != ADMIN) {
                    $userGroupPermissions = TableRegistry::get('UserGroupPermissions');
                    $userGroupPermissions->deleteAll(['user_group_id' => $id]);

                    $permission = [];
                    $current    = date('Y-m-d H:i:s');
                    foreach ($data['access'] as $code => $checked) {
                        if ($checked) {
                            $permission[] = [
                                'user_group_id' => $id,
                                'code'          => $code,
                                'created_at'    => $current,
                                'updated_at'    => $current,
                            ];
                        }
                    }

                    $entities = $userGroupPermissions->newEntities($permission);
                    $userGroupPermissions->saveMany($entities);

                    $key = 'permission_users_' . $id;
                    Cache::delete($key);
                }

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
     * View method
     *
     * @param string|null $id $modelAlias id.
     *
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $userGroupPermissions = TableRegistry::get('UserGroupPermissions');
        $item       = $this->UserGroups->get($id, [
            'finder'  => 'translations',
            'contain' => [],
        ]);
        $listPermissions = $userGroupPermissions->getListPermission($id);
        $accessArr = [];
        foreach ($listPermissions as $code) {
            $accessArr[$code] = ENABLED;
        }
        $item->access = $accessArr;

        $this->set(compact('item'));
        $this->_setVarToView();
    }
}
