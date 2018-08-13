<?php

namespace App\Controller\Admin;

use \Cake\Core\Configure;
use App\Form\Admin\LoginForm;
use Cake\ORM\TableRegistry;

/**
 * Class UsersController
 *
 * @property \App\Model\Table\UsersTable $Users
 * @package App\Controller\Admin
 */
class UsersController extends CommonController
{
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * Login for admin and supper admin
     * adminLogin method
     *
     * @return \Cake\Http\Response|null
     */
    public function login()
    {
        $this->set('title', 'Login');
        $this->viewBuilder()->setLayout('Admin/login');
        $loginForm = new LoginForm();

        if ($this->request->is('post')
            && $loginForm->validate($this->request->getData())
        ) {
            $users = $this->Auth->identify();
            if ($users) {
                $this->Auth->setUser($users);
                $this->Flash->success(
                    __(USER_MSG_0007, $this->Auth->user('email'))
                );

                return $this->redirect($this->Auth->redirectUrl());
            }

            $this->Flash->error(__(USER_MSG_0001));
        }

        $this->set(compact('loginForm'));
    }

    /**
     * Logout user from admin
     *
     * @return \Cake\Http\Response|null
     */
    public function logout()
    {
        $this->Flash->success(__(USER_MSG_0006));

        return $this->redirect($this->Auth->logout());
    }

    /**
     * Index method
     *
     * @param array $conditions
     */
    public function index($conditions = [])
    {
        $defaultStatus = [ENABLED, DISABLED];
        $search        = $this->request->getQueryParams();
        if (isset($search['status']) && is_numeric($search['status'])) {
            $defaultStatus = $search['status'];
        }
        $conditions = [
            'Users.status IN' => $defaultStatus,
            'Users.id !='     => $this->Auth->user('id'),
        ];
        $conditions = $this->_searchFiltersCondition($conditions, $search);

        $this->paginate = [
            'contain'    => [
                'UserGroups' => ['fields' => ['id', 'name']],
            ],
            'conditions' => $conditions,
            'order'      => [
                'Users.id DESC',
            ],
        ];
        $users          = $this->paginate($this->Users);
        $status         = Configure::read('system_status');
        $genders        = Configure::read('gender');
        $groups         = $this->Users->UserGroups->find('list',
            ['limit' => 100]);

        $this->set(compact('users', 'status', 'groups', 'search', 'genders'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     *
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $age  = 0;
        $user = $this->Users->get($id, [
            'finder'  => 'translations',
            'contain' => [
                'UserGroups',
            ],
        ]);

        $groups = $this->Users->UserGroups->find('list', ['limit' => 100]);

        if ( ! empty($user->birthday)) {
            $now = \Cake\I18n\Time::now();
            $age = date_diff(date_create($user->birthday),
                date_create($now))->format('%y');
        }
        $data = $this->Users->get($id, [
            'contain' => [
            ],
        ])->toArray();

        $this->set(compact('user', 'groups', 'status'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $data           = $this->request->getData();
            $data['status'] = ENABLED;

            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__(COMMON_MSG_0001));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__(COMMON_MSG_0002));
        }

        $groups = $this->Users->UserGroups->find('list', ['limit' => 100]);
        $this->set(compact('groups', 'user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     *
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            if (empty($data['password'])) {
                unset($data['password']);
            }

            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__(COMMON_MSG_0001));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__(COMMON_MSG_0002));
        }

        $groups = $this->Users->UserGroups->find('list', ['limit' => 100]);
        $this->set(compact('user', 'groups'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     *
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $item = $this->Users->get($id);
        if ($item->status === TRASH) {
            if ($this->Users->delete($item)) {
                $this->_afterDeleteSuccess($id);
                $this->Flash->success(__(COMMON_MSG_0003, h($id)));
            } else {
                $this->Flash->error(__(COMMON_MSG_0004));
            }
        } else {
            $item->status = TRASH;

            if ($this->Users->save($item)) {
                $this->_afterDeleteSuccess($id);
                $this->Flash->success(__(COMMON_MSG_0003, h($id)));
            } else {
                $this->Flash->error(__(COMMON_MSG_0004));
            }
        }

        return $this->redirect(['action' => 'index']);
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
            $keyword      = trim($params['keyword']);
            $conditions[] = [
                'OR' => [
                    'Users.email LIKE' => '%' . $keyword . '%',
                    'Users.name LIKE'  => '%' . $keyword . '%',
                    'Users.id LIKE'    => $keyword,
                ],
            ];
        }

        if ( ! empty($params['user_group_id'])) {
            $conditions['Users.user_group_id'] = trim($params['user_group_id']);
        }

        if ( ! empty($params['start_date'])) {
            $conditions[] = [
                'DATE(Users.created_at) >=' => $params['start_date'],
                'DATE(Users.created_at) <=' => $params['end_date'],
            ];
        }

        if (isset($params['status']) && is_numeric($params['status'])) {
            $conditions['Users.status'] = trim($params['status']);
        }

        return $conditions;
    }

    public function dashboard()
    {

    }

    public function searchResult()
    {

    }

    /**
     * get data tree
     *
     * @param array $arrData
     * @param null  $type
     * @param array $result
     *
     * @return array
     */
    private function _getDataTree($arrData = [], $type = null, $result = [])
    {
        if ( ! empty($arrData)) {
            foreach ($arrData as $value) {
                if ( ! empty($value['start_date'])) {
                    $start                           = strtotime($value['start_date']->format('Y-m-d'));
                    $year                            = date('Y', $start);
                    $month                           = date('m', $start);
                    $value['type']                   = $type;
                    $value['start']                  = true;
                    $result[$year][$month][$start][] = $value;
                }
                if ( ! empty($value['end_date']) && ! empty($start)) {
                    $end   = strtotime($value['end_date']->format('Y-m-d'));
                    $year  = date('Y', $end);
                    $month = date('m', $end);
                    if ($end !== $start) {
                        $value['type']                 = $type;
                        $value['start']                = false;
                        $result[$year][$month][$end][] = $value;
                    }
                }
            }
        }

        return $result;
    }

    /**
     * tree info
     *
     * @param null $id
     */
    public function tree($id = null)
    {
        $items = $this->Users->find()
            ->select(['id', 'name', 'email'])
            ->where(['status' => ENABLED, 'user_group_id' => MEMBER])
            ->enableHydration(false)
            ->toArray();
        if (empty($id)) {
            $objFirst = $this->Users->getFirstItems();
            $id       = $objFirst['id'];
        }

        $data      = $this->Users->get($id, [
            'contain' => [
                'UserJobs',
                'UserPrizes',
                'UserSkills',
                'UserExperiences',
                'UserSocialActivities',
            ],
        ])->toArray();
        $arrSkill  = $this->_getInfoTree($data['user_skills'], STREE_SKILL);
        $arrJob    = $this->_getInfoTree($data['user_jobs'], STREE_JOB,
            $arrSkill);
        $arrEx     = $this->_getInfoTree($data['user_experiences'],
            STREE_EXPERIENCE, $arrJob);
        $arrAc     = $this->_getInfoTree($data['user_social_activities'],
            STREE_ACTIVITY, $arrEx);
        $infoTrees = $this->_getInfoTree($data['user_prizes'], STREE_PRIZE,
            $arrAc);
        ksort($infoTrees);

        $this->set(compact('items', 'id', 'infoTrees'));
    }

    /**
     * get info tree
     *
     * @param array $arrData
     * @param null  $type
     * @param array $result
     *
     * @return array
     */
    private function _getInfoTree($arrData = [], $type = null, $result = [])
    {
        if ( ! empty($arrData)) {
            foreach ($arrData as $value) {
                if ( ! empty($value['start_date'])) {
                    $start            = strtotime($value['start_date']->format('Y-m-d'));
                    $value['type']    = $type;
                    $value['start']   = true;
                    $result[$start][] = $value;
                }
                if ( ! empty($value['end_date']) && ! empty($start)) {
                    $end = strtotime($value['end_date']->format('Y-m-d'));
                    if ($end !== $start) {
                        $value['type']  = $type;
                        $value['start'] = false;
                        $result[$end][] = $value;
                    }
                }
            }
        }

        return $result;
    }

    /**
     * My plans management
     *
     * @param null $id
     */
    public function myPlans($id = null)
    {
        if (empty($id)) {
            $objFirst = $this->Users->getFirstItems();
            $id       = $objFirst['id'];
        }
        $items = $this->Users->find()
            ->select(['id', 'name', 'email'])
            ->where(['status' => ENABLED, 'user_group_id' => MEMBER])
            ->enableHydration(false)
            ->toArray();

        $this->set(compact('items', 'id'));
        $this->_setVarToView();
    }
}
