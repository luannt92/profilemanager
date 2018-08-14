<?php

namespace App\Controller\Admin;

use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

/**
 * Class NewsController
 *
 * @property \App\Model\Table\NewsTable $News
 * @package App\Controller\Admin
 */
class NewsController extends CommonController
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
            $keyword      = trim($params['keyword']);
            $conditions[] = [
                'OR' => [
                    'News.title LIKE' => '%' . $keyword . '%',
                    'News.id'         => $keyword,
                ],
            ];
        }

        if (isset($params['status']) && is_numeric($params['status'])) {
            $conditions['News.status'] = trim($params['status']);
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
        $new = $this->News->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $this->_saveEntityRelated($data);

            $new          = $this->News->patchEntity($new,
                $this->request->getData(),
                ['associated' => ['Tags']]);
            $new->slug    = $this->convertToSlug($data['title']);
            $new->user_id = $this->Auth->user('id');

            if ($this->News->save($new)) {
                $this->Flash->success(__(COMMON_MSG_0001));

                return $this->redirect($this->getBackLink());
            } else {
                $error = $this->_displayErrors($new->getErrors());
                $this->Flash->error($error);
            }
        }

        $categories = $this->News->NewCategories->find('list')
            ->where(['status' => ACTIVE]);
        $tags       = $this->News->Tags->find('list')
            ->where(['status' => ACTIVE]);

        $this->set(compact('new', 'categories', 'tags'));
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
        /* @var \App\Model\Table\TagsTable $tagsObj */
        $tagsObj = TableRegistry::get('Tags');
        $new  = $this->_getNewsInfo($id);

        $tags = $tagsObj->getTagByNewID($id, true);

        $listCategories = $this->News->NewCategories->find('list')
            ->where(['status' => ACTIVE]);
        $listTags       = $this->News->Tags->find('list')
            ->where(['status' => ACTIVE]);

        $this->set(compact('new', 'tags', 'listCategories',
            'listTags'));
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    private function _getNewsInfo($id)
    {
        return $this->News->get($id, [
            'finder'  => 'translations',
//            'contain' => [
//                'Users' => [
//                    'fields' => [
//                        'Users.id',
//                        'Users.full_name',
//                    ],
//                ],
//            ],
        ]);
    }

    /**
     * Edit method
     *
     * @param string|null $id News id.
     *
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $new = $this->_getNewsInfo($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $this->_saveEntityRelated($data);
            $new = $this->News->patchEntity($new, $this->request->getData());
            if ($this->News->save($new)) {
                $this->Flash->success(__(COMMON_MSG_0001));

                return $this->redirect($this->getBackLink());
            } else {
                $error = $this->_displayErrors($new->getErrors());
                $this->Flash->error($error);
            }
        }

        $listCategories = $this->News->NewCategories->find('list')
            ->where(['status' => ACTIVE]);
        $listTags       = $this->News->Tags->find('list')
            ->where(['status' => ACTIVE]);

        /* @var \App\Model\Table\TagsTable $tagsObj */
        $tagsObj = TableRegistry::get('Tags');
        $tags    = $tagsObj->getTagByNewID($id, true);

        $this->set(compact('new', 'tags', 'listCategories', 'listTags'));
    }

    /**
     * Save to many entity related
     *
     * @param $data
     */
    private function _saveEntityRelated($data)
    {
        $tagsTable = TableRegistry::get('Tags');

        if ( ! empty($data['tags']['_ids'])) {
            /* @var \App\Model\Table\TagsTable $tagsTable */
            $this->request->data['tags']['_ids']
                = $tagsTable->getOrInsertTag($data['tags']['_ids']);
        }
    }
}
