<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;
use App\Form\LoginForm;
use App\Form\RegisterForm;
use App\Form\ContactForm;
use Cake\Routing\Router;
use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Hybridauth\Hybridauth;


use Cake\Cache\Cache;
use Cake\I18n\I18n;

/**
 * Class UsersApiController
 *
 * @property \App\Model\Table\UsersTable                $Users
 * @property \App\Controller\Component\CaptchaComponent $Captcha
 * @package App\Controller
 */
class UsersController extends CommonController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow([
            'updateCheckOut',
        ]);
    }

    /**
     * Login with member
     *
     * @return \Cake\Http\Response|null
     */
    public function login()
    {
        $this->viewBuilder()->setLayout('ajax');

        $loginForm = new LoginForm();
        if ($this->request->is('post')) {
            $arrMsg = [
                'success' => false,
                'message' => '',
            ];
            $data   = $this->request->getData();
            if ($loginForm->validate($data)) {
                $user = $this->Auth->identify();
                if ($user) {
                    if (in_array($user['status'],
                        array(REGISTER_STATUS, DISABLED, TRASH))
                    ) {
                        $arrMsg['message']
                            = $this->Users->_checkErrorStatus($user['status']);
                    } else {
                        $this->Auth->setUser($user);
                        $user = $this->Users->get($user['id']);

                        $user->last_access = date('Y-m-d H:i:s');
                        if ($this->Users->save($user)) {
                            /** @var \App\Model\Table\UserLogsTable $userLog */
                            $userLog = TableRegistry::get('UserLogs');
                            $userLog->updateLoginNumber($user->id);

                            $arrMsg['success']  = true;
                            $arrMsg['redirect'] = $this->Auth->redirectUrl();
                        }
                    }
                } else {
                    $arrMsg['message'] = __(USER_MSG_0018, 'Email', 'password');
                }
            } else {
                $arrMsg['message']
                    = $this->_displayErrors($loginForm->errors());
            }

            echo json_encode($arrMsg);
            die;
        }

        $this->set(compact('loginForm'));
    }


    /**
     * Logout user from member
     *
     * @return \Cake\Http\Response|null
     */
    public function logout()
    {
        $this->Flash->success(__(USER_MSG_0006));

        return $this->redirect($this->Auth->logout());
    }

    /**
     * Register member
     */
    public function register()
    {
        $this->viewBuilder()->setLayout('ajax');

        $registerForm = new RegisterForm();
        if ($this->request->is('post')) {
            $data   = $this->request->getData();
            $arrMsg = [
                'success' => false,
                'message' => '',
            ];
            if ($registerForm->validate($data)) {
                $user = $this->Users->findByEmail($data['email'])->toArray();
                if ($user) {
                    $arrMsg['message'] = __(USER_MSG_0016);
                } else {
                    if ($this->Users->register($data)) {
                        $arrMsg['success']  = true;
                        $arrMsg['redirect'] = Router::url(['action' => 'home']);
                        if (empty($data['unLoad'])) {
                            $this->Flash->greatMessage(__(USER_MSG_0031));
                        }
                    } else {
                        $arrMsg['message'] = __(USER_MSG_0020);
                    }
                }
            } else {
                $arrMsg['message']
                    = $this->_displayErrors($registerForm->errors());
            }

            echo json_encode($arrMsg);
            die;
        }

        $this->set(compact('registerForm'));
    }

    /**
     * Confirm active link from email
     */
    public function active()
    {
        $query = $this->request->getQueryParams();
        if ( ! empty($query['key'])) {
            $user = $this->Users->activeAccount($query);

            if ( ! $user) {
                $this->Flash->error(__(USER_MSG_0025));
            } else {
                $this->Flash->greatMessage(__(USER_MSG_0024));

                // Log user in using Auth
                $this->Auth->setUser($user);

                $this->redirect(array('action' => 'account'));
            }
        }

        return $this->redirect(['action' => 'home']);
    }

    /**
     * Forgot password for member
     */
    public function forgotPassword()
    {
        $this->viewBuilder()->setLayout('ajax');

        if ($this->request->is('post')) {
            $data   = $this->request->getData();
            $arrMsg = [
                'success' => false,
                'message' => '',
            ];
            $user   = $this->Users->forgotPassword($data);

            if ($user === -1) {
                $arrMsg['message'] = __(USER_MSG_0043);
            } else if ($user === true) {
                $this->Flash->greatMessage(__(USER_MSG_0034));
                $arrMsg['success']  = true;
                $arrMsg['redirect'] = Router::url(['action' => 'home']);
            } else {
                $arrMsg['message'] = __(USER_MSG_0021);
            }

            echo json_encode($arrMsg);
            die;
        }
    }

    /**
     * This is function confirm password change for user
     * confirm method
     */
    public function confirmPasswordAjax()
    {
        $this->viewBuilder()->setLayout('ajax');

        $query = $this->request->getQueryParams();
        if ($this->request->is('post')) {
            $data   = $this->request->getData();
            $arrMsg = [
                'success' => false,
                'message' => '',
            ];

            if ( ! empty($query['key']) && ! empty($query['request'])) {
                $email = base64_decode($query['request']);
                if ($query['key'] === md5(date('Ymd') . $email)) {
                    $user = $this->Users->find()->select(['id', 'email'])
                        ->where([
                            'email'  => $email,
                            'status' => ENABLED,
                        ])->first();

                    if ($user) {
                        $user = $this->Users->confirmPassword($email,
                            $data['newPassword']);
                        if ($user) {
                            $this->Flash->greatMessage(__(USER_MSG_0047));
                            $arrMsg['success'] = true;
                            $arrMsg['redirect']
                                               = Router::url(['action' => 'home']);
                        } else {
                            $arrMsg['message'] = __(USER_MSG_0021);
                        }
                    } else {
                        $arrMsg['message'] = __(USER_MSG_0048);
                    }
                } else {
                    $arrMsg['message'] = __(USER_MSG_0035);
                }
            } else {
                $arrMsg['message'] = __(USER_MSG_0022);
            }

            echo json_encode($arrMsg);
            die;
        }
    }

    /**
     * This is function confirm password for user
     * confirm method
     */
    public function confirmPassword()
    {
        $query = $this->request->getQueryParams();
        if ( ! empty($query['key']) && ! empty($query['request'])) {
            $email = base64_decode($query['request']);
            if ($query['key'] === md5(date('Ymd') . $email)) {
                $this->Flash->confirmPassword(null, [
                    'params' => [
                        'request' => $query['request'],
                        'key'     => $query['key'],
                    ],
                ]);

                return $this->redirect(['action' => 'home']);
            } else {
                $this->Flash->greatMessage(__(USER_MSG_0035));
            }
        } else {
            $this->Flash->error(__(USER_MSG_0022));
        }

        return $this->redirect(['action' => 'home']);
    }

    /**
     * @param string $provider
     */
    function socialLogin($provider = '')
    {
        $this->autoRender = false;
        $provider         = ucfirst($provider);

        if (in_array($provider, ['Facebook'])) {
            try {
                $this->request->getSession()->start();

                $config             = Configure::read('SocialLogin');
                $config['callback'] = Router::url([
                    'controller' => 'Users',
                    'action'     => 'socialLogin',
                    $provider,
                ], true);

                $hybridAuth = new Hybridauth($config);
                $hybridAuth->disconnectAllAdapters();
                $adapter = $hybridAuth->authenticate($provider);
                $profile = $adapter->getUserProfile();

                if ( ! empty($profile)) {
                    $user = $this->Users->_findOrCreateUser($profile,
                        $provider);
                    if ( ! empty($user)) {
                        $this->Auth->setUser($user);
                        //Disconnect the adapter
                        $adapter->disconnect();

                        $this->redirect($this->Auth->redirectUrl());
                    }
                } else {
                    $this->Flash->error(__(USER_MSG_0036));
                }
            } catch (Exception $e) {
                $error = __(USER_MSG_0037);
                switch ($e->getCode()) {
                    case 6 :
                        $error = __(USER_MSG_0038, $provider);
                        break;
                    case 7 :
                        $error = __(USER_MSG_0039, $provider);
                        break;
                }
                $this->Flash->error($error);
            }
        } else {
            $this->Flash->error(__(USER_MSG_0039, $provider));
        }

        $this->redirect(['action' => 'home']);
    }


    /**
     * home page
     */
    public function home()
    {

    }

    /**
     * @param null $slug
     */
    public function pages($slug = null)
    {
        $menus = $this->_getMenus(TYPE_PAGE);

        /**@var \App\Model\Table\PagesTable $pageTbl */
        $pageTbl = TableRegistry::get('Pages');
        $page    = $pageTbl->findBySlug($slug)->enableHydration(false)->first();

        $this->set(compact('menus', 'page'));
    }

    /**
     * account page
     */
    public function account()
    {
        $userId     = $this->Auth->user('id');
        $addressRec = [];
        $hotel      = $ward = null;
        $user       = $this->Users->get($userId);
        /**@var  \App\Model\Table\AddressesTable $addressTbl */
        $addressTbl      = TableRegistry::get('Addresses');
        $conditions      = [
            'type'         => DEFAULT_ADDRESS,
            'type_address' => RECIPIENT_ADDRESS,
        ];
        $addressShipping = $addressTbl->getAddressesByUserId($userId,
            $conditions, false, [], [], 1);
        if ( ! empty($addressShipping['address'])) {
            $addressArr = json_decode($addressShipping['address'], true);
            $addressRec = array_merge(['id' => $addressShipping['id']],
                (array)$addressArr);

            /**@var \App\Model\Table\HotelsTable $hotelTbl */
            if ($addressRec['typeAddress'] == HOTEL) {
                $hotelTbl = TableRegistry::get('Hotels');
                $hotel    = $hotelTbl->findById($addressRec['hotel'])
                    ->enableHydration(false)->first();
            } else if ($addressRec['typeAddress'] == HOUSE) {
                $shippingZoneTbl = TableRegistry::get('ShippingZones');
                $shippingZone
                                 = $shippingZoneTbl->findById($addressRec['areaOrder'])
                    ->enableHydration(false)->first();
            }
        }
        /* $conditions = [
             'type'         => DEFAULT_ADDRESS,
             'type_address' => PAYMENT_ADDRESS,
         ];
         $addressPay = $addressTbl->getAddressesByUserId($userId, $conditions);*/

        /**@var \App\Model\Table\OrdersTable $orderTbl */
        $orderTbl   = TableRegistry::get('Orders');
        $conditions = ['status !=' => CANCEL];
        $order      = ['status' => 'ASC', 'time' => 'DESC'];
        $orders     = $orderTbl->getOrdersByUserId($userId, $conditions,
            false, [], $order, ORDER_LIMIT);

        $this->set(compact('user', 'addressRec', 'orders', 'hotel',
            'shippingZone'));
    }

    /**
     * edit info user
     */
    public function edit()
    {
        $userId = $this->Auth->user('id');
        $user   = $this->Users->get($userId);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data     = $this->request->getData();
            $user     = $this->Users->patchEntity($user, $data);
            $response = $this->Users->save($user);
            if ($response) {
                $user = $response;
                $this->Flash->success(__(COMMON_MSG_0001));
            } else {
                $this->Flash->error(__(COMMON_MSG_0002));
            }
        }

        $this->set(compact('user'));
    }

    /**
     * change password account
     */
    public function changePassword()
    {
        $userId = $this->Auth->user('id');
        $user   = $this->Users->get($userId);

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if (md5($data['oldPassword']) === $user->password) {
                if ($data['password'] === $data['confirmPassword']) {
                    $user->password = $data['password'];
                    if ($this->Users->save($user)) {
                        $this->Flash->success(__(COMMON_MSG_0001));
                    }
                } else {
                    $this->Flash->error(__(USER_MSG_0014, "confirm password"));
                }
            } else {
                $this->Flash->error(__(USER_MSG_0014, "old password"));
            }
        }

        $this->set(compact('user'));
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function contact()
    {
        $this->set('title', 'Liên hệ');

        /** @var \App\Model\Table\SettingsTable $settingTbl */
        $settingTbl = TableRegistry::get('Settings');
        /**@var \App\Model\Table\SupportsTable $supportTbl */
        $supportTbl   = TableRegistry::get('Supports');
        $condition    = [
            'OR' => [
                ['name LIKE' => 'site_%'],
                ['name LIKE' => 'contact_%'],
            ],
        ];
        $dataSettings = $settingTbl->getListSetting([], $condition);
        $dataSupports = $supportTbl->getListSupports();
        $contactForm  = new ContactForm();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $contactForm->setCaptcha($this->Captcha->getCaptchaCode($data['captchaId']));
            if ($contactForm->validate($data)
                && ! empty($dataSettings['site_mail'])
            ) {
                if ($this->Users->contact($data,
                    $dataSettings['site_mail'])
                ) {
                    $this->Flash->success(__(USER_MSG_0044));

                    return $this->redirect('/');
                } else {
                    $this->Flash->error(__(USER_MSG_0045));
                }
            } else {
                $error = $this->_displayErrors($contactForm->errors());
                $this->Flash->error($error);
            }
        }

        $this->set(compact('contactForm', 'dataSettings', 'dataSupports'));
    }

    /**
     *  generate image for contact
     *
     * @param null $captchaId
     */
    public function captcha($captchaId = null)
    {
        $this->autoRender = false;
        $this->viewBuilder()->setLayout('ajax');
        $this->Captcha->create($captchaId);
    }

    /**
     * Request ajax to check cart
     */
    public function updateCheckOut()
    {
        if ($this->request->data('key')) {
            $data = $this->request->data();
            if ($data['key'] == 'updateCart') {
                $this->updateCart($data['type'], $data['id']);
            } elseif ($data['key'] == 'removeCart') {
                $this->removeProduct($data['id']);
            } elseif ($data['key'] == 'noteCart') {
                $this->noteProduct($data['id'], $data['note']);
            }
        }
    }

    public function updateLanguage()
    {
        I18n::setLocale('en');
        $i18nTable = TableRegistry::get('I18ns');
        $i18ns     = $i18nTable->find('all')->toArray();
        foreach ($i18ns as $i18n) {
            $modelTable = TableRegistry::get($i18n->model);
            $model      = $modelTable->find('all')->where([
                $i18n->model . '.id' => $i18n->foreign_key,
            ])->first()->toArray();
            $modelTable->updateAll([$i18n->field => $i18n->content],
                ['id' => $i18n->foreign_key]);
            $i18nTable->updateAll(['content' => $model[$i18n->field]],
                ['id' => $i18n->id]);
        }
        exit;
    }
}
