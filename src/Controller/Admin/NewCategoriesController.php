<?php

namespace App\Controller\Admin;

use \Cake\Core\Configure;

/**
 * Class NewCategoriesController
 *
 * @property \App\Model\Table\NewCategoriesTable $NewCategories
 * @package App\Controller\Admin
 */
class NewCategoriesController extends CommonController
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
                    'NewCategories.name LIKE' => '%' . $keyword . '%',
                    'NewCategories.id LIKE'   => $keyword,
                ],
            ];
        }

        if (isset($params['status']) && is_numeric($params['status'])) {
            $conditions['NewCategories.status'] = trim($params['status']);
        }

        return $conditions;
    }

    /**
     * Set variable to view
     */
    protected function _setVarToView()
    {
        $status = Configure::read('system_status');

        $categories = $this->NewCategories->find('list');

        $this->set(compact('status', 'categories'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $item = $this->NewCategories->newEntity();

        if ($this->request->is('post')) {
            $data           = $this->request->getData();
            $data['status'] = ACTIVE;
            if ( ! empty($data['name'])) {
                $data['slug'] = $this->convertToSlug($data['name']);
            }
            $item = $this->NewCategories->patchEntity($item, $data);

            if ($this->NewCategories->save($item)) {
                $this->Flash->success(__(COMMON_MSG_0001));

                return $this->redirect($this->getBackLink());
            } else {
                $error = $this->_displayErrors($item->getErrors());
                $this->Flash->error($error);
            }
        }

        $categories = $this->NewCategories->find('list');

        $this->set(compact('item', 'categories'));
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
        $item = $this->NewCategories->get($id, [
            'finder'  => 'translations',
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data     = $this->request->getData();
            $dataSave = $this->NewCategories->patchEntity($item, $data);

            if ($this->NewCategories->save($dataSave)) {
                $this->Flash->success(__(COMMON_MSG_0001));

                return $this->redirect($this->getBackLink());
            } else {
                $error = $this->_displayErrors($dataSave->getErrors());
                $this->Flash->error($error);
            }
        }

        $categories = $this->NewCategories->find('list')->where([
            'NewCategories.id !=' => $id,
        ]);

        $this->set(compact('item', 'categories'));
    }
}
