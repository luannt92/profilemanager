<?php

namespace App\Controller\Admin;

use Cake\Core\Configure;

/**
 * Class SlidersController
 *
 * @property \App\Model\Table\SlidersTable $Sliders
 * @package App\Controller\Admin
 */
class SlidersController extends CommonController
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
            $conditions['Sliders.title LIKE'] = '%' . trim($params['keyword'])
                . '%';
        }

        if (isset($params['status']) && is_numeric($params['status'])) {
            $conditions['Sliders.status'] = trim($params['status']);
        }

        return $conditions;
    }

    /**
     * Set variable to view
     */
    protected function _setVarToView()
    {
        $status     = Configure::read('system_status');
        $sliderType = Configure::read('slider_types');

        $this->set(compact('status', 'sliderType'));
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
            'Sliders.status IN' => [ACTIVE, DEACTIVE, TRASH],
        ];
        $search     = $this->request->getQueryParams();
        $conditions = $this->_searchFiltersCondition($conditions, $search);

        $this->paginate = [
            'conditions' => $conditions,
            'order'      => [
                'Sliders.id' => 'DESC',
            ],
        ];
        $items          = $this->paginate($this->Sliders);

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
        $item = $this->Sliders->newEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            if ($data['type'] == SLIDER_VIDEO) {
                $data['url'] = $this->_checkLink($data['video']);
            }

            $item          = $this->Sliders->patchEntity($item, $data);
            $item->user_id = $this->Auth->user('id');

            if ($this->Sliders->save($item)) {
                $this->Flash->success(__(COMMON_MSG_0001));

                return $this->redirect($this->getBackLink());
            } else {
                $error = $this->_displayErrors($item->getErrors());
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
        $item = $this->Sliders->get($id, [
            'finder'  => 'translations',
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            if ($data['type'] == SLIDER_VIDEO) {
                $data['url'] = $this->_checkLink($data['video']);
            }

            $dataSave = $this->Sliders->patchEntity($item, $data);

            if ($this->Sliders->save($dataSave)) {
                $this->Flash->success(__(COMMON_MSG_0001));

                return $this->redirect($this->getBackLink());
            } else {
                $error = $this->_displayErrors($item->getErrors());
                $this->Flash->error($error);
            }
        }

        $this->set(compact('item'));
        $this->_setVarToView();
    }

    /**
     * check link
     *
     * @param $url
     *
     * @return string
     */
    private function _checkLink($url)
    {
        $re
               = '/^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})?$/';
        $reUrl = '/^(?:(https|http)?:\/\/)(?:www\.)?(.)*$/';

        if (preg_match($re, $url, $marches)) {
            return $marches[0];
        }

        if (preg_match($reUrl, $url, $marches)) {
            return $url;
        }

        return '/source/' . preg_replace('/[\/?source]*\//', '', $url);
    }
}
