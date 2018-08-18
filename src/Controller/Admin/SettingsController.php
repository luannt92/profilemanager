<?php

namespace App\Controller\Admin;

use App\Form\Admin\SettingsForm;
use Cake\Cache\Cache;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

/**
 * Settings Controller
 *
 * @property \App\Model\Table\SettingsTable $Settings
 */
class SettingsController extends CommonController
{
    /**
     * Using for access with action
     *
     * @var array
     */
    protected $_allowAction = ['update', 'switchery'];

    public function initialize()
    {
        parent::initialize();
    }

    /**
     * Update settings for Systems
     */
    public function update()
    {
        $settingForm = new SettingsForm();
        $arrData     = [];
        $errors      = [];
        $data        = $this->request->getData();

        if ($this->request->is(['patch', 'post', 'put'])) {
            if ($settingForm->validate($data)) {
                $list     = $this->Settings->find('all')->toArray();
                $settings = $this->Settings->getListSetting([
                    'keyField'   => 'name',
                    'valueField' => 'id',
                ]);
                foreach ($data as $key => $value) {
                    $arrData[] = empty($settings[$key])
                        ? ['name' => $key, 'value' => $value]
                        : ['id' => $settings[$key], 'value' => $value,];
                }

                $entities = $this->Settings->patchEntities($list, $arrData);

                if ($this->Settings->saveMany($entities)) {
                    $this->Flash->success(__(COMMON_MSG_0001));
                    Cache::delete('settingsFooter');
                    Cache::delete(KEY_COMMON_CACHE);

                    return $this->redirect(['action' => 'update']);
                }
            }

            $errors = $settingForm->errors();

            $this->Flash->error(__(COMMON_MSG_0002));
        }

        if (empty($data)) {
            $conditions   = [
                'OR' => [
                    ['name LIKE' => 'site_%'],
                    ['name LIKE' => 'meta_%'],
                    ['name LIKE' => 'me_%'],
                ],
            ];
            $dataSettings = $this->Settings->getListSetting([], $conditions);
            foreach ($dataSettings as $key => $val) {
                $this->request->data($key, $val);
            }
        }

        $this->set(compact('settingForm', 'errors', 'news'));
    }

    /**
     * switcher field
     */
    public function switchery()
    {
        $result = [
            'status'  => false,
            'message' => COMMON_MSG_0002,
        ];

        if ($this->request->is('post')) {
            $data    = $this->request->getData();
            $setting = $this->Settings->findByName($data['name'])->first();
            if ( ! empty($setting)) {
                if ($data['check'] == 1) {
                    $result = [
                        'status' => true,
                        'data'   => $setting->status,
                    ];
                } else {
                    $setting->status = $data['status'];
                    if ($this->Settings->save($setting)) {
                        $result = [
                            'status'  => true,
                            'message' => COMMON_MSG_0001,
                        ];
                        Cache::delete(KEY_COMMON_CACHE);
                    }
                }
            }
        }

        echo json_encode($result);
        die;
    }
}

