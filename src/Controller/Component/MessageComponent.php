<?php

namespace App\Controller\Component;

use Cake\Cache\Cache;
use Cake\Controller\Component;
use Cake\Http\Client;
use Cake\ORM\TableRegistry;

/**
 * Message component
 */
class MessageComponent extends Component
{
    public function slack($data)
    {
        $http      = new Client();
        $jsonSlack = [
            'username'    => '[PhuQuocDelivery]',
            'text'        => $data,
            'attachments' => [
                [
                    'fallback'    => 'PhuQuocDelivery',
                    'color'       => '#36a64f',
                    'footer'      => 'PhuQuocDelivery',
                    'footer_icon' => 'https://platform.slack-edge.com/img/default_application_icon.png',
                ],
            ],
        ];
        $http->setConfig(['headers' => ['Content-Type' => 'application/json']]);
        $http->post(
            'https://hooks.slack.com/services/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',
            json_encode($jsonSlack)
        );
    }

    /**
     * send message zalo
     *
     * @param null $mess
     */
    public function zalo($mess = null)
    {
        $key = KEY_COMMON_CACHE;
        if (($setting = Cache::read($key)) === false) {
            $settingTbl = TableRegistry::get('Settings');
            $conditions = [
                'name IN' => [
                    'site_zalo_id',
                    'site_zalo_key',
                    'site_zalo_phones',
                    'site_zalo_message',
                ],
            ];

            /* @var \App\Model\Table\SettingsTable $settingTbl */
            $setting = $settingTbl->getListSetting([], $conditions);
        }
        $oaid   = $setting['site_zalo_id'];
        $key    = $setting['site_zalo_key'];
        $mess   = empty($mess) ? $setting['site_zalo_message'] : $mess;
        $phones = explode(',', $setting['site_zalo_phones']);
        if ( ! empty($phones) && ! empty($oaid) && ! empty($key)
            && ! empty($mess)
        ) {
            $time = time();
            foreach ($phones as $phone) {
                $phone = trim($phone);
                $hash  = $oaid . $phone . $time . $key;
                $data  = [
                    'oaid'      => $oaid,
                    'uid'       => $phone,
                    'timestamp' => $time,
                ];
                //get key zalo phone number
                $user = $this->_callZaloOA(LINK_ZALO_OA_GET_PROFILE, $hash,
                    $data);
                $user = json_decode($user->getBody()->getContents(), true,
                    512, JSON_BIGINT_AS_STRING);
                //send message for userId
                if ( ! empty($user['data'])) {
                    $text = ['uid'     => $user['data']['userId'],
                             'message' => $mess,
                    ];
                    $text = json_encode($text);
                    $hash = $oaid . $text . $time . $key;
                    $data = [
                        'oaid'      => $oaid,
                        'data'      => $text,
                        'timestamp' => $time,
                    ];
                    $this->_callZaloOA(LINK_ZALO_OA_SEND_TEXT, $hash, $data,
                        'post')->getBody()->getContents();
                }
            }
        }
    }

    /**
     *  call api zalo OA
     *
     * @param        $link
     * @param string $hash
     * @param array  $data
     * @param string $method
     *
     * @return Client\Response
     */
    private function _callZaloOA($link, $hash = "", $data = [], $method = 'get')
    {
        $http = new Client();
        $mac  = hash('sha256', utf8_encode($hash));
        $data = array_merge($data, ['mac' => $mac]);

        if (strtolower($method) === 'post') {
            return $http->post($link, $data);
        }

        return $http->get($link, $data);
    }
}
