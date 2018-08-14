<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Aura\Intl\Exception;
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\Mailer\Email;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\I18n\FrozenTime;
use Cake\I18n\I18n;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

class CommonController extends AppController
{
    /**
     * Using for access with action
     *
     * @var array
     */
    protected $_allowAction = [];

    /**
     * Using for access with action
     *
     * @var array
     */
    protected static $_excludePermission
        = [
            'login',
            'summary',
            'logout',
            'direct',
        ];

    public function initialize()
    {
        parent::initialize();
        FrozenTime::setDefaultLocale('en_US');

        $this->loadComponent('Paginator');
        $this->loadComponent(
            'Auth', [
                'authenticate'         => [
                    'Form' => [
                        'fields'         => [
                            'username' => 'email',
                            'password' => 'password',
                        ],
                        'finder'         => 'authAdmin',
                        'passwordHasher' => [
                            'className' => 'Fallback',
                            'hashers'   => [
                                'Default',
                                'Weak' => ['hashType' => 'md5'],
                            ],
                        ],
                    ],
                ],
                'loginAction'          => [
                    'controller' => 'Users',
                    'action'     => 'login',
                ],
                'loginRedirect'        => [
                    'controller' => 'Users',
                    'action'     => 'index',
                ],
                'unauthorizedRedirect' => $this->referer(),
            ]
        );

        $languages = Configure::read('system_languages');
        $this->set(compact('languages'));

        $this->viewBuilder()->setLayout('Admin/default');
    }

    /**
     * @param Event $event
     *
     * @return \Cake\Http\Response|null
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $actions = $this->request->getParam('action');
        if ( ! empty($this->_allowAction)
            && ! in_array($actions, $this->_allowAction)
            || ! $this->_checkPermission()
        ) {
            $this->Flash->error(__(USER_MSG_0049));

            return $this->redirect($this->referer());
        }
    }

    /**
     * Index method
     *
     * @param array $conditions
     */
    public function index($conditions = [])
    {
        $this->setReturnUrl();

        $modelAlias = $this->_getModelAlias();
        $search     = $this->request->getQueryParams();

        if ($this->$modelAlias->hasField('status')) {
            $defaultStatus = [ENABLED, DISABLED];

            if (isset($search['status']) && is_numeric($search['status'])) {
                $defaultStatus = $search['status'];
            }
            $conditions[$modelAlias . '.status IN'] = $defaultStatus;
        }

        $conditions = $this->_searchFiltersCondition($conditions, $search);

        $this->paginate = [
            'contain'    => [],
            'conditions' => $conditions,
            'order'      => [
                $modelAlias . '.id' => 'DESC',
            ],
        ];
        $items          = $this->paginate($this->$modelAlias);
        $this->set(compact('items', 'search'));
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
        $modelAlias = $this->_getModelAlias();
        $item       = $this->$modelAlias->get($id, [
            'finder'  => 'translations',
            'contain' => [],
        ]);

        $this->set(compact('item'));
        $this->_setVarToView();
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $modelAlias = $this->_getModelAlias();
        $item       = $this->$modelAlias->newEntity();

        if ($this->request->is('post')) {
            $data           = $this->request->getData();
            $data['status'] = ! empty($data['status']) ? $data['status']
                : ENABLED;

            $dataSave = $this->$modelAlias->patchEntity($item, $data);
            if ($this->$modelAlias->save($dataSave)) {
                $this->Flash->success(__(COMMON_MSG_0001));

                $session    = $this->request->getSession();
                $controller = $this->request->getParam('controller');
                $userId     = $this->Auth->user('id');
                $session->write($userId . $controller,
                    $_SERVER['QUERY_STRING']);

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
        $modelAlias = $this->_getModelAlias();
        $item       = $this->$modelAlias->get($id, [
            'finder'  => 'translations',
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            $dataSave = $this->$modelAlias->patchEntity($item, $data);
            if ($this->$modelAlias->save($dataSave)) {
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
        $modelAlias = $this->_getModelAlias();
        $this->request->allowMethod(['post', 'delete']);
        $item = $this->$modelAlias->get($id);

        if ( ! $this->$modelAlias->hasField('status')) {
            $this->removeRecord($id, $modelAlias, $item);
        } else {
            if ($item->status === TRASH) {
                $this->removeRecord($id, $modelAlias, $item);
            } else {
                $item->status = TRASH;

                if ($this->$modelAlias->save($item)) {
                    $this->_afterDeleteSuccess($id);
                    $this->Flash->success(__(COMMON_MSG_0003, h($id)));
                } else {
                    $this->Flash->error(__(COMMON_MSG_0004));
                }
            }
        }

        return $this->redirect($this->getBackLink());
    }

    /**
     * @param $id
     * @param $modelAlias
     * @param $item
     */
    protected function removeRecord($id, $modelAlias, $item)
    {
        if ($this->$modelAlias->delete($item)) {
            $this->_afterDeleteSuccess($id);
            $this->Flash->success(__(COMMON_MSG_0003, h($id)));
        } else {
            $this->Flash->error(__(COMMON_MSG_0004));
        }
    }

    /**
     * @param       $conditions
     * @param array $params
     *
     * @return mixed
     */
    protected function _searchFiltersCondition($conditions, $params = [])
    {
        return $conditions;
    }

    /**
     * Set variable to view
     */
    protected function _setVarToView()
    {
    }

    /**
     * save and check after after edit success
     *
     * @param null  $id
     * @param array $arrParams
     */
    protected function _afterUpdateSuccess($id = null, $arrParams = [])
    {
    }

    /**
     * save and check after after delete success
     *
     * @param null $id
     */
    protected function _afterDeleteSuccess($id = null)
    {
    }

    /**
     * Get model name
     * Inflector::humanize(Inflector::singularize($controller));
     *
     * @return string
     */
    private function _getModelAlias()
    {
        $controller = $this->request->getParam('controller');
        $modelAlias = Inflector::camelize($controller);

        return $modelAlias;
    }

    /**
     * Delete selected
     *
     * @return \Cake\Http\Response|null
     */
    public function deleteSelected()
    {
        $modelAlias = $this->_getModelAlias();
        if ($this->request->is('post')) {
            $status = $this->request->getData('statusExc');

            $listId    = $this->request->getData('selectedAll');
            $arrStatus = [ENABLED, DISABLED, TRASH, REMOVE_RECORD];

            if (in_array($status, $arrStatus) && ! empty($listId)) {
                $listId = explode(",", $listId);
                if ($status === REMOVE_RECORD) {
                    $this->$modelAlias->deleteAll([
                        'id IN ' => $listId,
                    ]);
                } else {
                    $this->$modelAlias->updateAll(
                        ['status' => $status],
                        ['id IN ' => $listId]
                    );
                }

                $this->Flash->success(__(COMMON_MSG_0005));
            } else {
                $this->Flash->error(__(COMMON_MSG_0006));
            }
        }

        return $this->redirect($this->referer());
    }


    /**
     * Delete Ajax method
     *
     * @param string|null $id $modelAlias id.
     *
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function deleteAjax($id = null)
    {
        $modelAlias = $this->_getModelAlias();
        $this->request->allowMethod(['post', 'delete']);
        $item = $this->$modelAlias->get($id);
        $arr  = [
            'success' => false,
            'message' => __(COMMON_MSG_0004),
        ];

        if ($this->$modelAlias->delete($item)) {
            $arr = [
                'success' => true,
                'message' => __(COMMON_MSG_0003, h($id)),
            ];
        }
        echo json_encode($arr);
        die;
    }

    /**
     * Edit Ajax method
     *
     * @param string|null $id $modelAlias id.
     *
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function editAjax($id = null)
    {
        $modelAlias = $this->_getModelAlias();
        $item       = $this->$modelAlias->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            $dataSave = $this->$modelAlias->patchEntity($item, $data);
            $arr      = [
                'success' => false,
                'message' => __(COMMON_MSG_0002),
            ];
            if ($this->$modelAlias->save($dataSave)) {
                $this->_afterUpdateSuccess($id, $data);
                $arr = [
                    'success' => true,
                    'message' => __(COMMON_MSG_0001),
                    'data'    => $data,
                ];
            }
            echo json_encode($arr);
        }
        die;
    }

    /**
     * @param $arrErrors
     *
     * @return string
     */
    protected function _displayErrors($arrErrors)
    {
        $errorMsg = [];
        if ( ! empty($arrErrors)) {
            foreach ($arrErrors as $errors) {
                if (is_array($errors)) {
                    foreach ($errors as $error) {
                        $errorMsg[] = __($error);
                    }
                } else {
                    $errorMsg[] = __($errors);
                }
            }
        }

        return ! empty($errorMsg) ? implode("\n \r", $errorMsg) : null;
    }

    /**
     * Check permission by groups
     *
     * @return bool
     */
    private function _checkPermission()
    {
        $controller = $this->request->getParam('controller');
        $action     = $this->request->getParam('action');

        $userGroupType = $this->Auth->user('user_group_id');
//        $this->log($userGroupType);
        if ( ! empty($userGroupType)
            && in_array($userGroupType, [SUPER_ADMIN, ADMIN])
        ) {
            $isAdmin                = true;
            $currentUserPermissions = [];
            $this->set(compact('currentUserPermissions', 'isAdmin'));

            return true;
        }

        $isAdmin                = false;
        $permissions            = Configure::read('permissions');
        $currentUserPermissions = $this->_getCurrentUserPermission();

        $this->set(compact('currentUserPermissions', 'isAdmin'));

        if (in_array($action, self::$_excludePermission)
            || ( ! empty($permissions[$controller][$action])
                && ! empty($currentUserPermissions[$permissions[$controller][$action]]))
        ) {
            return true;
        }

        return false;
    }

    /**
     * Get current user permission by group
     *
     * @return mixed
     */
    private function _getCurrentUserPermission()
    {
        $key = 'permission_users_' . $this->Auth->user('usg.id');

        if (($userInfo = Cache::read($key)) === false) {
            $groupsPermissionTbl = TableRegistry::getTableLocator()
                ->get('UserGroupPermissions');
            $userGroupId         = $this->Auth->user('user_group_id');

            /* @var \App\Model\Table\UserGroupPermissionsTable $groupsPermissionTbl */
            $userInfo
                = $groupsPermissionTbl->getListPermission($userGroupId);
            Cache::write($key, $userInfo);
        }

        return $userInfo;
    }

    protected function getEmailAdmin()
    {
        $userTbl = TableRegistry::getTableLocator()->get('Users');
        $users   = $userTbl->find('all', [
            'fields'     => ['email', 'full_name'],
            'conditions' => ['UserGroups.type' => 1],
            'contain'    => ['UserGroups'],
        ]);
        $count   = $users->count();
        $to      = '';
        $cc      = [];
        if ($count > 0) {
            $stt = 1;
            foreach ($users as $user) {
                if ($stt === 1) {
                    $to = $user->email;
                } else {
                    $cc[] = $user->email;
                }
            }

        }

        return [
            'to' => $to,
            'cc' => $cc,
        ];
    }

    /**
     * Return when press back link
     */
    public function setReturnUrl()
    {
        $session    = $this->request->getSession();
        $controller = $this->request->getParam('controller');
        $userId     = $this->Auth->user('id');
        $query      = ! empty($this->request->getQueryParams())
            ? $this->request->getQueryParams() : '';
        $session->write('Link.' . $userId . $controller, $query);
    }

    /**
     * @return array|null|string
     */
    public function getReturnUrl()
    {
        $session    = $this->request->getSession();
        $controller = $this->request->getParam('controller');
        $userId     = $this->Auth->user('id');

        return $session->read('Link.' . $userId . $controller);
    }

    /**
     * Get back link
     *
     * @return array
     */
    public function getBackLink()
    {
        $backLink = ['action' => 'index'];
        $query    = $this->getReturnUrl();
        if ( ! empty($query)) {
            $backLink['?'] = $query;
        }

        return $backLink;
    }

    /**
     * Get config from setting
     */
    protected function _getConfigs()
    {
        $key = KEY_COMMON_ADMIN_CACHE;

        if (($settingInfo = Cache::read($key)) === false) {
            $settingTbl = TableRegistry::getTableLocator()->get('Settings');
            $conditions = [
                'OR' => [
                    [
                        'name IN' => [
                            'site_mail',
                        ],
                    ],
                ],
                ['status' => ENABLED],
            ];

            /* @var \App\Model\Table\SettingsTable $settingTbl */
            $settingInfo = $settingTbl->getListSetting([], $conditions);
            Cache::write($key, $settingInfo);
        }

        return $settingInfo;
    }

    /**
     * this is function send email with options
     * sendMail method
     *
     * @param        $subject
     * @param        $body
     * @param        $to
     * @param array  $viewVarsOption
     * @param string $config
     * @param null   $attachedFile
     * @param string $format
     *
     * @return bool
     */
    public function sendMail(
        $subject,
        $body,
        $to,
        $viewVarsOption = [],
        $format = 'html',
        $config = 'gmail',
        $attachedFile = null
    ) {
        $isSendMail = false;
        try {
            $viewVarsArr = array_merge(array(
                'user'        => $to,
                'title'       => $subject,
                'settingInfo' => $this->_getConfigs(),
            ), $viewVarsOption);
            $email       = new Email($config);
            $email->setTemplate('default')
                ->setTransport('gmail')
                ->setEmailFormat($format)
                ->setTo($to)
                ->setSubject($subject)
                ->setViewVars($viewVarsArr);
            if ( ! empty($attachedFile)) {
                $email->addAttachments($attachedFile);
            }

            if ($email->send($body)) {
                $isSendMail = true;
            }
        } catch (Exception $ex) {
            $isSendMail = false;
        }

        return $isSendMail;
    }
}