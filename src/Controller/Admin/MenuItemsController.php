<?php

namespace App\Controller\Admin;

use Cake\Cache\Cache;

/**
 * Class MenuItemsController
 *
 * @property \App\Model\Table\MenuItemsTable $MenuItems
 * @package App\Controller\Admin
 */
class MenuItemsController extends CommonController
{
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $item = $this->MenuItems->newEntity();

        if ($this->request->is('post')) {
            $data           = $this->request->getData();
            $data['status'] = ACTIVE;

            $dataSave = $this->MenuItems->patchEntity($item, $data);
            if ($this->MenuItems->save($dataSave)) {
                $this->Flash->success(__(COMMON_MSG_0001));

                return $this->redirect($this->getBackLink());
            }
            $this->Flash->error(__(COMMON_MSG_0002));
        }
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
        $result = [
            'status'  => false,
            'message' => __(COMMON_MSG_0002),
        ];

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            if ( ! empty($data['id'])) {
                $id   = $data['id'];
                $item = $this->MenuItems->get($id, [
                    'contain' => [],
                ]);

                $dataSave = $this->MenuItems->patchEntity($item, $data);
                if ($this->MenuItems->save($dataSave)) {
//                    $this->_deleteCacheData();
                    $result = [
                        'status'  => true,
                        'message' => __(COMMON_MSG_0001),
                    ];
                }
            }
        }

        echo json_encode($result);
        die;
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
        $result = [
            'status'  => false,
            'message' => __(COMMON_MSG_0002),
        ];

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            if ( ! empty($data['id'])) {
                $id   = $data['id'];
                $item = $this->MenuItems->get($id);

                if ($this->MenuItems->delete($item)) {
                    $this->_deleteCacheData();

                    $result = [
                        'status'  => true,
                        'message' => __(COMMON_MSG_0001),
                    ];
                }
            }
        }

        echo json_encode($result);
        die;
    }

    /**
     * Delete cache from menu
     */
    private function _deleteCacheData()
    {
        Cache::delete(CACHE_MENU);
    }
}
