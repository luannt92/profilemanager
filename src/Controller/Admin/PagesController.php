<?php

namespace App\Controller\Admin;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\I18n\I18n;

/**
 * Class PagesController
 *
 * @package App\Controller\Admin
 */
class PagesController extends CommonController
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
        I18n::setLocale('vi_VN');
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
            $conditions['Pages.title LIKE'] = '%' . trim($params['keyword'])
                . '%';
        }

        if (isset($params['status']) && is_numeric($params['status'])) {
            $conditions['Pages.status'] = trim($params['status']);
        }

        return $conditions;
    }

    /**
     * Set variable to view
     */
    protected function _setVarToView()
    {
        $status = Configure::read('system_status');
        $types = Configure::read('type_pages');

        $this->set(compact('status','types'));
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($conditions = [])
    {
        $conditions = [
            'Pages.status IN' => [ACTIVE, DEACTIVE],
        ];
        $search     = $this->request->getQueryParams();
        $conditions = $this->_searchFiltersCondition($conditions, $search);

        $this->paginate = [
            'contain'    => [
                'Users' => [
                    'fields' => [
                        'Users.id',
                        'Users.name',
                    ],
                ],
            ],
            'conditions' => $conditions,
            'order'      => [
                'Pages.id DESC',
            ],
        ];
        $items          = $this->paginate($this->Pages);

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
        $languageArr = LANGUAGE;
        $item        = $this->Pages->newEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if ($this->Pages->checkType($data['type']) || $data['status'] == DEACTIVE) {
                $item          = $this->Pages->patchEntity($item, $data);
                $item->user_id = $this->Auth->user('id');
                $item->slug    = $this->convertToSlug($data['title']);
                foreach ($data as $datKey => $value){
                    if (array_key_exists($datKey, $languageArr)) {
                        $item->translation($datKey)->set($data[$datKey], ['guard' => false]);
                    }
                }
                if ($this->Pages->save($item)) {
                    $this->Flash->success(__(COMMON_MSG_0001));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__(COMMON_MSG_0002));
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
        $languageArr = LANGUAGE;
        $item        = $this->Pages->get($id, [
            'finder' => 'translations',
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            if ($this->Pages->checkType($data['type'], $id) || $data['status'] == DEACTIVE) {
                $dataSave = $this->Pages->patchEntity($item, $data);
                foreach ($data as $datKey => $value){
                    if (array_key_exists($datKey, $languageArr)) {
                        $dataSave->translation($datKey)->set($data[$datKey], ['guard' => false]);
                    }
                }
                if ($this->Pages->save($dataSave)) {
                    $this->Flash->success(__(COMMON_MSG_0001));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__(COMMON_MSG_0002));
            }
            $this->Flash->error(__(COMMON_MSG_0002));
        }

        $this->set(compact('item'));
        $this->_setVarToView();
    }
}
