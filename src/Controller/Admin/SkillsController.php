<?php

namespace App\Controller\Admin;

use Cake\Core\Configure;

/**
 * Class SkillsController
 *
 * @property \App\Model\Table\SkillsTable $Skills
 * @package App\Controller\Admin
 */
class SkillsController extends CommonController
{
    /**
     * Using for access with action
     *
     * @var array
     */
    protected $_allowAction
        = ['index', 'add', 'edit', 'view', 'delete'];

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
            $conditions['Skills.title LIKE'] = '%' . trim($params['keyword'])
                . '%';
        }

        if (isset($params['status']) && is_numeric($params['status'])) {
            $conditions['Skills.status'] = trim($params['status']);
        }

        return $conditions;
    }

    /**
     * Set variable to view
     */
    protected function _setVarToView()
    {
        $status     = Configure::read('system_status');
        $optionType = Configure::read('type_Skills');

        $this->set(compact('status', 'optionType'));
    }

    /**
     * Index method
     *
     * @param array $conditions
     */
    public function index($conditions = [])
    {
        $this->setReturnUrl();
        $conditions = [
            'Skills.status IN' => [ACTIVE, DEACTIVE, TRASH],
        ];
        $search     = $this->request->getQueryParams();
        $conditions = $this->_searchFiltersCondition($conditions, $search);

        $this->paginate = [
            'conditions' => $conditions,
            'order'      => [
                'Skills.id' => 'DESC',
            ],
        ];
        $items          = $this->paginate($this->Skills);

        $this->set(compact('items', 'search'));
        $this->_setVarToView();
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $item = $this->Skills->newEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if ($this->Skills->checkType($data['type'])
                || $data['status'] == DEACTIVE
            ) {
                $item          = $this->Skills->patchEntity($item, $data);
                $item->user_id = $this->Auth->user('id');
                if ( ! empty($data['title'])) {
                    $item->slug = $this->convertToSlug($data['title']);
                }

                if ($this->Skills->save($item)) {
                    $this->Flash->success(__(COMMON_MSG_0001));

                    return $this->redirect($this->getBackLink());
                } else {
                    $error = $this->_displayErrors($item->getErrors());
                    $this->Flash->error($error);
                }
            } else {
                $this->Flash->error(__(COMMON_MSG_0002));
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
        $item = $this->Skills->get($id, [
            'finder'  => 'translations',
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            if ($this->Skills->checkType($data['type'], $id)
                || $data['status'] == DEACTIVE
            ) {
                $dataSave = $this->Skills->patchEntity($item, $data);

                if ($this->Skills->save($dataSave)) {
                    $this->Flash->success(__(COMMON_MSG_0001));

                    return $this->redirect($this->getBackLink());
                } else {
                    $error = $this->_displayErrors($dataSave->getErrors());
                    $this->Flash->error($error);
                }
            } else {
                $this->Flash->error(__(COMMON_MSG_0002));
            }
        }

        $this->set(compact('item'));
        $this->_setVarToView();
    }
}
