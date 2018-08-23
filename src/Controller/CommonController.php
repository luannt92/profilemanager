<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\Http\Client;
use Cake\Mailer\Email;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Cache\Cache;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Utility\Security;
use Cake\I18n\I18n;

/**
 * Class CommonApiController
 *
 * @package App\Controller
 */
class CommonController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Captcha');
        $this->loadComponent('Message');
        $this->loadComponent(
            'Auth', [
                'authError'            => 'Vui lòng đăng nhập để sử dụng tính năng này!',
                'authenticate'         => [
                    'Form' => [
                        'fields'         => [
                            'username' => 'email',
                            'password' => 'password',
                        ],
                        'finder'         => 'authMember',
                        'passwordHasher' => [
                            'className' => 'Fallback',
                            'hashers'   => [
                                'Default',
                                'Weak' => ['hashType' => 'md5'],
                            ],
                        ],
                    ],
                ],
                'loginAction'          => [
                    'controller' => 'Users',
                    'action'     => 'home',
                ],
                'loginRedirect'        => [
                    'controller' => 'Users',
                    'action'     => 'account',
                ],
                'unauthorizedRedirect' => $this->referer(),
            ]
        );

        $this->changeLanguage();
        $settingInfo = $this->_getConfigs();
        $menuHeaders = $this->_getMenus(MENU_HEADER);
//        $menuFooters = $this->_getMenus(MENU_FOOTER);
//        $menuLinks   = $this->_getMenus(MENU_LINK);

        $this->set(compact('menuHeaders', 'settingInfo', 'menuFooters',
            'menuLinks'));
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow([
            'home',
            'login',
            'logout',
            'register',
            'confirm',
            'active',
            'socialLogin',
            'forgotPassword',
            'confirmPassword',
            'confirmPasswordAjax',
            'socialRedirect',
            'contact',
            'about',
            'index',
            'view',
            'captcha',
        ]);
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
    public function isValidURL($url)
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
     * @return null|string
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
        $key = KEY_COMMON_CACHE;

        if (($settingInfo = Cache::read($key)) === false) {
            $settingTbl = TableRegistry::getTableLocator()->get('Settings');
            $conditions = [
                'OR' => [
                    [
                        'name IN' => [
                            'site_name',
                        ],
                    ],
                    ['name LIKE' => 'site_mail_%'],
                    ['name LIKE' => 'me_%'],
                    ['name LIKE' => 'meta_%'],
                ],
                ['status' => ENABLED],
            ];

            /* @var \App\Model\Table\SettingsTable $settingTbl */
            $settingInfo = $settingTbl->getListSetting([], $conditions);
            Cache::write($key, $settingInfo);
        }

        return $settingInfo;
    }

    /**
     * @param $typeMenu
     *
     * @return array
     */
    protected function _setVarToView()
    {

    }

    /**
     * @param $typeMenu
     *
     * @return array
     */
    public function _getMenus($typeMenu)
    {
        $locale = I18n::getLocale();
        $key    = KEY_MENU_CACHE . $typeMenu . '_' . $locale;

        if (($result = Cache::read($key)) === false) {
            $tableMenus = TableRegistry::getTableLocator()->get('Menus');
            $menus      = $tableMenus->findByType($typeMenu)->first();
            if ( ! empty($menus)) {
                $tableMenuItems = TableRegistry::getTableLocator()
                    ->get('MenuItems');

                $fields     = [
                    'id',
                    'name',
                    'url',
                    'parent_id',
                    'type'
                ];
                $conditions = [
                    'status'  => ACTIVE,
                    'menu_id' => $menus->id,
                ];

                $result = $tableMenuItems->find('threaded')
                    ->where($conditions)
                    ->select($fields)
                    ->toArray();

                Cache::write($key, $result);
            }
        }

        return $result;
    }

    /**
     * change language method
     */
    public function changeLanguage()
    {
        $language     = 'vi';
        $languageText = 'vi_VN';

        $languageCheck = $this->request->getQuery('language');
        $languageCheck = ! empty($languageCheck)
            ? $languageCheck
            :
            $this->request->getParam('language');

        if ( ! empty($languageCheck)) {
            switch ($languageCheck) {
                case 'en':
                    $language     = 'en';
                    $languageText = 'en_US';
                    break;
            }
        }

        I18n::setLocale($language);
        $this->set(compact('languageText', 'language'));
    }

    function generateRandomString($length = 10)
    {
        $characters       = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString     = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}