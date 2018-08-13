<?php

namespace App\Controller\Admin;

use App\Form\Admin\SettingsForm;
use Cake\Cache\Cache;

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
    protected $_allowAction = ['update'];

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
                    Cache::delete('setting_for_site_lucky');

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
                    ['name LIKE' => 'contact_%'],
                    ['name LIKE' => 'seo_%'],
                ],
            ];
            $dataSettings = $this->Settings->getListSetting([], $conditions);
            foreach ($dataSettings as $key => $val) {
                $this->request->data($key, $val);
            }
        }

        $this->set(compact('settingForm', 'errors'));
    }
}

