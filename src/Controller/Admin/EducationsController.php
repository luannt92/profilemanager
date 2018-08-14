<?php

namespace App\Controller\Admin;

use Cake\Core\Configure;

/**
 * Class EducationsController
 *
 * @property \App\Model\Table\EducationsTable $Educations
 * @package App\Controller\Admin
 */
class EducationsController extends CommonController
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
            $conditions['Educations.title LIKE'] = '%' . trim($params['keyword'])
                . '%';
        }

        if (isset($params['status']) && is_numeric($params['status'])) {
            $conditions['Educations.status'] = trim($params['status']);
        }

        return $conditions;
    }

    /**
     * Set variable to view
     */
    protected function _setVarToView()
    {
        $status     = Configure::read('system_status');
        $optionType = Configure::read('type_Educations');

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
            'Educations.status IN' => [ACTIVE, DEACTIVE, TRASH],
        ];
        $search     = $this->request->getQueryParams();
        $conditions = $this->_searchFiltersCondition($conditions, $search);

        $this->paginate = [
            'conditions' => $conditions,
            'order'      => [
                'Educations.id' => 'DESC',
            ],
        ];
        $items          = $this->paginate($this->Educations);

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
        $item = $this->Educations->newEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if ($this->Educations->checkType($data['type'])
                || $data['status'] == DEACTIVE
            ) {
                $item          = $this->Educations->patchEntity($item, $data);
                $item->user_id = $this->Auth->user('id');
                if ( ! empty($data['title'])) {
                    $item->slug = $this->convertToSlug($data['title']);
                }

                if ($this->Educations->save($item)) {
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
        $item = $this->Educations->get($id, [
            'finder'  => 'translations',
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            if ($this->Educations->checkType($data['type'], $id)
                || $data['status'] == DEACTIVE
            ) {
                $dataSave = $this->Educations->patchEntity($item, $data);

                if ($this->Educations->save($dataSave)) {
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
