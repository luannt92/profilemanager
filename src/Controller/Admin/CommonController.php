<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\I18n\FrozenTime;

class CommonController extends AppController
{
    /**
     * Using for access with action
     *
     * @var array
     */
    protected $_allowAction = [];

    public function initialize()
    {
        parent::initialize();
//        FrozenTime::setDefaultLocale('en_US');

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

        $actions = $this->request->getParam('action');
        if ( ! empty($this->_allowAction)
            && ! in_array($actions, $this->_allowAction)
        ) {
            die;
        }

        $this->viewBuilder()->setLayout('Admin/default');
    }

    /**
     * Index method
     *
     * @param array $conditions
     */
    public function index($conditions = [])
    {
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
                $modelAlias . '.id DESC',
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
            'finder' => 'translations',
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
        $language   = LANGUAGE;
        $modelAlias = $this->_getModelAlias();
        $item       = $this->$modelAlias->newEntity();

        if ($this->request->is('post')) {
            $data           = $this->request->getData();
            $data['status'] = ENABLED;

            $dataSave = $this->$modelAlias->patchEntity($item, $data);
            foreach ($data as $datKey => $item){
                if (array_key_exists($datKey, $language)) {
                    $dataSave->translation($datKey)->set($data[$datKey], ['guard' => false]);
                }
            }
            if ($this->$modelAlias->save($dataSave)) {
                $this->Flash->success(__(COMMON_MSG_0001));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__(COMMON_MSG_0002));
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
        $language   = LANGUAGE;
        $modelAlias = $this->_getModelAlias();
        $item       = $this->$modelAlias->get($id, [
            'finder' => 'translations',
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            $dataSave = $this->$modelAlias->patchEntity($item, $data);
            foreach ($data as $datKey => $item){
                if (array_key_exists($datKey, $language)) {
                    $dataSave->translation($datKey)->set($data[$datKey], ['guard' => false]);
                }
            }
            if ($this->$modelAlias->save($dataSave)) {
//                $this->_afterUpdateSuccess($id, $data);
                $this->Flash->success(__(COMMON_MSG_0001));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__(COMMON_MSG_0002));
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

        return $this->redirect(['action' => 'index']);
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
            $status    = $this->request->getData('statusExc');
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
     * convert to slug
     *
     * @param $slug
     *
     * @return string
     */
    public function convertToSlug($slug)
    {
        return Text::slug(mb_strtolower($slug, 'UTF-8'));
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

}
