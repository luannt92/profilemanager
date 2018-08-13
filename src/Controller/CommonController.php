<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\Mailer\Email;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Cache\Cache;
use Cake\Event\Event;
use Cake\Utility\Security;

/**
 * Class CommonController
 *
 * @package App\Controller
 */
class CommonController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->_setVarToView();
        $settingInfo = $this->_getConfigs();
        $menuHeaders = $this->getMenus(MENU_HEADER);
        $menuFooters = $this->getMenus(MENU_FOOTER);

        $this->set(compact('menuHeaders', 'menuFooters', 'settingInfo'));
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }

    /**
     * secret and unique hash using for cookie.
     *
     * @return string
     */
    public function _hashGenerator()
    {
        return Security::hash(rand());
    }

    /**
     * this is function send email with options
     * sendMail method
     *
     * @param        $subject
     * @param        $body
     * @param        $to
     * @param array  $viewVarsOption
     * @param string $config
     * @param null   $attachedFile
     * @param string $format
     *
     * @return bool
     */
    public function sendMail(
        $subject,
        $body,
        $to,
        $viewVarsOption = [],
        $format = 'html',
        $config = 'gmail',
        $attachedFile = null
    ) {
        $isSendMail = false;
        try {
            $viewVarsArr = array_merge(array(
                'user'        => $to,
                'title'       => $subject,
                'settingInfo' => $this->_getConfigs(),
            ), $viewVarsOption);
            $email       = new Email($config);
            $email->setTemplate('default')
                ->setTransport('gmail')
                ->setEmailFormat($format)
                ->setTo($to)
                ->setSubject($subject)
                ->setViewVars($viewVarsArr);
            if ( ! empty($attachedFile)) {
                $email->addAttachments($attachedFile);
            }

            if ($email->send($body)) {
                $isSendMail = true;
            }
        } catch (Exception $ex) {
            $isSendMail = false;
        }

        return $isSendMail;
    }

    /**
     * @param $url
     *
     * @return int
     */
    function isValidURL($url)
    {
        return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i',
            $url);
    }

    /**
     * @param $email
     *
     * @return int
     */
    public function checkEmail($email)
    {
        return preg_match(
            '/^[a-zA-z0-9_\.]+@[a-zA-Z0-9]+\.+[a-zA-Z]{2,}$/', $email
        );
    }

    /**
     * @param $arrErrors
     *
     * @return array
     */
    protected function _displayErrors($arrErrors)
    {
        $errorMsg = [];
        if ( ! empty($arrErrors)) {
            foreach ($arrErrors as $errors) {
                if (is_array($errors)) {
                    foreach ($errors as $error) {
                        $errorMsg[] = $error;
                    }
                } else {
                    $errorMsg[] = $errors;
                }
            }
        }

        return ! empty($errorMsg) ? implode("\n \r", $errorMsg) : null;
    }

    /**
     * Get config from setting
     */
    private function _getConfigs()
    {
        $key = 'setting_for_site_lucky';

        if (($settingInfo = Cache::read($key)) === false) {
            /* @var \App\Model\Table\SettingsTable $settingTbl */
            $settingTbl  = TableRegistry::get('Settings');
            $conditions  = [
                'OR' => [
                    [
                        'name IN' => [
                            'site_mail',
                            'site_facebook',
                            'site_linked',
                            'site_tag',
                            'contact_description',
                            'site_phone',
                        ],
                    ],
                    ['name LIKE' => 'seo_%'],
                ],
            ];
            $settingInfo = $settingTbl->getListSetting([], $conditions);
            Cache::write($key, $settingInfo);
        }

        $this->set(compact('settingInfo'));

        return $settingInfo;
    }


    /**
     * Set variable to view
     */
    protected function _setVarToView()
    {
        $supportsTbl  = TableRegistry::get('Supports');
        $partnersTbl  = TableRegistry::get('Partners');
        $cateToursTbl = TableRegistry::get('TravelCategories');
        $locationsTbl = TableRegistry::get('Locations');
        $bannersTbl   = TableRegistry::get('Banners');
        $condition    = ['status' => ENABLED];

        $pricesSearch    = Configure::read('price_tours');
        $membersSearch   = Configure::read('member_tours');
        $cateToursSearch = $cateToursTbl->getTravelCategories($condition, true);
        $locationsSearch = $locationsTbl->getAllLocations($condition, true);
        $banners         = $bannersTbl->getAllBanners($condition, false,
            ['position' => 'DESC'], null, []);

        $supports = $supportsTbl->find()->enableHydration(false)->toArray();
        $partners = $partnersTbl->find()->enableHydration(false)->toArray();

        $this->set(compact('supports', 'partners', 'banners', 'cateToursSearch',
            'locationsSearch', 'pricesSearch', 'membersSearch'));
    }

    function getMenus($typeMenu)
    {
        $tableMenus = TableRegistry::get('MenuItems');

        $fields     = [
            'id',
            'name',
            'url',
            'parent_id',
            'type',
        ];
        $conditions = [
            'status'  => ACTIVE,
            'menu_id' => $typeMenu,
        ];
        $menus      = $tableMenus->find('threaded')
            ->where($conditions)
            ->select($fields)
            ->toArray();

        return $menus;
    }
}