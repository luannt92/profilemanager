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

//        $menuHeaders = $this->_getMenus(MENU_HEADER);
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
            $settingTbl = TableRegistry::get('Settings');
            $conditions = [
                'OR' => [
                    [
                        'name IN' => [
                            'site_mail',
                            'download_android',
                            'download_ios',
                            'site_facebook',
                            'site_phone',
                            'site_zalo_id',
                            'site_zalo_key',
                            'site_zalo_phones',
                            'site_zalo_message',
                            'site_logo_footer',
                            'time_open',
                            'time_close',
                            'site_layout_product',
                            'link_zone',
                            'site_banner_popup',
                            'site_banner_popup_link',
                            'site_tracking_popup',
                            'site_tag',
                            'site_mail_order_receipt',
                        ],
                    ],
                    ['name LIKE' => 'meta_%'],
                    ['name LIKE' => 'site_address_%'],
                    ['name LIKE' => 'site_sale_off_%'],
                ],
                ['status' => ENABLED],
            ];

            /* @var \App\Model\Table\SettingsTable $settingTbl */
            $settingInfo = $settingTbl->getListSetting([], $conditions);
            Cache::write($key, $settingInfo);
        }

        return $settingInfo;
    }

    private function _getZones()
    {
        $key = 'zones_for_site_dpd';

        if (($zoneInfo = Cache::read($key)) === false) {
            $zoneTbl    = TableRegistry::get('ShippingZones');
            $conditions = [
            ];

            /* @var \App\Model\Table\SettingsTable $settingTbl */
            $zoneInfo = $zoneTbl->getZones();
            Cache::write($key, $zoneInfo);
        }

        return $zoneInfo;
    }

    private function _getWards()
    {
        $key = 'wards_for_site_dpd';

        if (($wardInfo = Cache::read($key)) === false) {
            $wardsTbl   = TableRegistry::get('Wards');
            $conditions = [

            ];
            /* @var \App\Model\Table\WardsTable $wardsTbl */
            $wardInfo = $wardsTbl->getObjectList();
            Cache::write($key, $wardInfo);
        }

        return $wardInfo;
    }

    /**
     * @param $typeMenu
     *
     * @return array
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
            $tableMenus = TableRegistry::get('Menus');
            $menus      = $tableMenus->findByType($typeMenu)->first();
            if ( ! empty($menus)) {
                $tableMenuItems = TableRegistry::get('MenuItems');

                $fields     = [
                    'id',
                    'name',
                    'url',
                    'parent_id',
                    'type',
                    'icon',
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

    public function addToCart($id = null, $option = [], $quantity = '')
    {
        $session       = $this->request->getSession();
        $productsTable = TableRegistry::get('Products');

        $product          = $productsTable->getFirstProducts(['Products.id' => $id]);
        $product_price    = $product['price'];
        $product_discount = 0;
        if ( ! empty($product['product_discounts'])) {
            $product['price'] = $product['price'] + ($product['commission']
                    / 100 * $product['price'])
                - $product['product_discounts'][0]['percent'] / 100
                * $product['price'];
            $product_discount = $product['product_discounts'][0]['percent'];
        } else {
            $product['price'] = $product['price'] + ($product['commission']
                    / 100 * $product['price']);
        }

        $nameOption                = '';
        $txtProductAttributeValues = '';
        $totalOptions              = 0;
        $arrOption                 = [];
        $promotion                 = ! empty($product['promotion'])
            ? $product['promotion']['description'] : '';

        if ( ! empty($option)) {
            $option = explode(',', $option);
            sort($option);
            $nameOption = implode('', $option);

            $productAttributeValuesTable
                                      = TableRegistry::get('ProductAttributeValues');
            $productAttributeValues
                                      = $productAttributeValuesTable->getProductAttributeValuesById(['ProductAttributeValues.id IN' => $option]);
            $txtProductAttributeValue = [];
            foreach ($productAttributeValues as $productAttributeValue) {
                if ( ! empty($product['product_discounts'])) {
                    $productAttributeValue['price']
                        = $productAttributeValue['price']
                        + ($product['commission'] / 100
                            * $productAttributeValue['price'])
                        - ($product['product_discounts'][0]['percent'] / 100
                            * $productAttributeValue['price']);
                } else {
                    $productAttributeValue['price']
                        = $productAttributeValue['price']
                        + ($product['commission'] / 100
                            * $productAttributeValue['price']);
                }

                $txtProductAttributeValue[] = $productAttributeValue['name'];
                $totalOptions               += $productAttributeValue['price'];
                $arrOption[$productAttributeValue['id']]
                                            = $productAttributeValue['price'];
            }
            $txtProductAttributeValues = implode(', ',
                $txtProductAttributeValue);
        }
        $quantity = empty($quantity) ? 1 : $quantity;

        $checkProduct = $session->read('cart.' . $id
            . $nameOption);

        if ( ! empty($checkProduct)) {
            $item = $session->read('cart.' . $id
                . $nameOption);

            $item['quantity'] += $quantity;
        } else {
            $item = [
                'id'                 => $product['id'],
                'name'               => $product['name'],
                'slug'               => $product['slug'],
                'image'              => $product['image'],
                'price'              => $product['price'],
                'description'        => $product['description'],
                'product_price'      => $product_price,
                'product_discount'   => $product_discount,
                'product_commission' => $product['commission'],
                'store_discount'     => $product['store']['discount'],
                'promotion'          => $promotion,
                'quantity'           => $quantity,
                'total_options'      => $totalOptions,
                'name_option'        => $nameOption,
                'product_note'       => '',
                'hideOption'         => $arrOption,
                'displayOption'      => $txtProductAttributeValues,
            ];
        }

        /** Create cart and add product to cart */
        $session->write('cart.' . $id . $nameOption, $item);

        /** Sum price cart */
        $carts = $session->read('cart');
        $total = $this->_sumCart($carts);
        $ship  = $session->read('feeship') == '' ? 0
            : $session->read('feeship');
        $sale  = $this->calPriceDiscount($total);
        $pay   = $total - $sale + $ship;

        $countProduct = $this->countProduct($carts);

        $session->write('payment.total', $total);
        $session->write('payment.pay', $pay);
        $session->write('payment.discount', $sale);

        $renderView = $this->render('viewcart');
        $response   = [
            'render'       => $renderView->body(),
            'total'        => $total,
            'pay'          => $pay,
            'ship'         => $ship,
            'sale'         => $sale,
            'countProduct' => $countProduct,
        ];

        return $this->returnAjax($response);
    }

    public function removeProduct($id)
    {
        $session = $this->request->getSession();
        $session->delete('cart.' . $id);
        $carts  = $session->read('cart');
        $reload = false;
        if (empty($carts)) {
            $session->delete('cart');
            $session->delete('payment');
            $session->delete('feeship');
            $total  = 0;
            $reload = true;
        } else {
            $total = $this->_sumCart($carts);
        }
        $ship         = $session->read('feeship') == '' ? 0
            : $session->read('feeship');
        $sale         = $this->calPriceDiscount($total);
        $pay          = $total - $sale + $ship;
        $countProduct = $this->countProduct($carts);

        $session->write('payment.total', $total);
        $session->write('payment.pay', $pay);
        $session->write('payment.discount', $sale);

        $renderView = $this->render('viewcart');
        $response   = [
            'render'       => $renderView->body(),
            'total'        => $total,
            'pay'          => $pay,
            'ship'         => $ship,
            'sale'         => $sale,
            'countProduct' => $countProduct,
            'reload'       => $reload,
        ];

        return $this->returnAjax($response);
    }

    public function updateCart($type, $id)
    {
        $session = $this->request->getSession();
        $reload  = false;
        if ($type == '1') {
            $item             = $session->read('cart.'
                . $id);
            $item['quantity'] += 1;
            $session->write('cart.' . $id, $item);
        } else {
            $item = $session->read('cart.' . $id);
            if ($item['quantity'] == 1) {
                $session->delete('cart.' . $id);
                if (empty($session->read('cart'))) {
                    $reload = true;
                    $session->delete('feeship');
                }
            } else {
                $item             = $session->read('cart.' . $id);
                $item['quantity'] -= 1;
                $session->write('cart.' . $id, $item);
            }
        }

        $carts        = $session->read('cart');
        $total        = $this->_sumCart($carts);
        $ship         = $session->read('feeship') == '' ? 0
            : $session->read('feeship');
        $sale         = $this->calPriceDiscount($total);
        $pay          = $total - $sale + $ship;
        $countProduct = $this->countProduct($carts);

        $session->write('payment.total', $total);
        $session->write('payment.pay', $pay);
        $session->write('payment.discount', $sale);

        $renderView = $this->render('viewcart');
        $response   = [
            'render'       => $renderView->body(),
            'total'        => $total,
            'pay'          => $pay,
            'ship'         => $ship,
            'sale'         => $sale,
            'countProduct' => $countProduct,
            'reload'       => $reload,
        ];

        return $this->returnAjax($response);
    }

    /**
     * @param $total
     *
     * @return int
     */
    public function calPriceDiscount($total)
    {
        $session       = $this->request->getSession();
        $discountType  = $session->check('payment.voucherType')
            ? $session->read('payment.voucherType') : 0;
        $discountValue = $session->check('payment.voucherValue')
            ? $session->read('payment.voucherValue') : 0;

        return $this->getPriceDiscount($discountType, $discountValue, $total);
    }

    /** Get price shipping */
    public function getShipping($type, $check)
    {
        $session        = $this->request->getSession();
        $shipingZoneTbl = TableRegistry::get('ShippingZones');

        if ($check == HOTEL) {
            $zone = $shipingZoneTbl->findByType($type)->first();
        } else {
            $zone = $shipingZoneTbl->findByName($type)->first();
        }

        $session->write('feeship', $zone['price']);

        $carts = $session->read('cart');

        $total = $this->_sumCart($carts);
        $ship  = $session->read('feeship') == '' ? 0
            : $session->read('feeship');
        $sale  = $this->calPriceDiscount($total);
        $pay   = $total - $sale + $ship;

        $countProduct = $this->countProduct($carts);

        $session->write('payment.total', $total);
        $session->write('payment.pay', $pay);
        $session->write('payment.discount', $sale);

        $renderView = $this->render('viewcart');
        $response   = [
            'render'       => $renderView->body(),
            'total'        => $total,
            'pay'          => $pay,
            'ship'         => $ship,
            'sale'         => $sale,
            'countProduct' => $countProduct,
        ];

        return $this->returnAjax($response);
    }

    /** remove price shipping */
    public function removeShipping($idHotel)
    {
        $session   = $this->request->getSession();
        $moneyShip = 0;
        $zoneName  = '';
        $hotelTbl  = TableRegistry::get('Hotels');
        $getHotel  = $hotelTbl->findById($idHotel)->contain([
            'ShippingZones' => [
                'fields' => [
                    'id',
                    'name',
                    'price',
                ],
            ],
        ])->first();
        if ($getHotel) {
            $moneyShip = $getHotel['shipping_zone']['price'];
            $zoneName  = $getHotel['shipping_zone']['name'];
        }
        $carts = $session->read('cart');
        $total = $this->_sumCart($carts);
        $session->write('feeship', $moneyShip);
        $ship = $session->read('feeship');
        $sale = $this->calPriceDiscount($total);
        $pay  = $total - $sale + $ship;

        $countProduct = $this->countProduct($carts);

        $session->write('payment.total', $total);
        $session->write('payment.pay', $pay);
        $session->write('payment.discount', $sale);

        $renderView = $this->render('viewcart');
        $response   = [
            'render'       => $renderView->body(),
            'total'        => $total,
            'pay'          => $pay,
            'ship'         => $moneyShip = ($moneyShip == 0) ? __('Contact')
                : $moneyShip,
            'sale'         => $sale,
            'countProduct' => $countProduct,
            'zoneName'     => $zoneName = ($zoneName == '') ? '' : $zoneName,
        ];

        return $this->returnAjax($response);
    }

    public function noteProduct($id, $note)
    {
        $session              = $this->request->getSession();
        $item                 = $session->read('cart.' . $id);
        $item['product_note'] = $note;

        $session->write('cart.' . $id, $item);

        $renderView = $this->render('viewcart');

        $response = [
            'render' => $renderView->body(),
            'note'   => $item['product_note'],
        ];

        return $this->returnAjax($response);
    }

    private function countProduct($carts = [])
    {
        $countProduct = 0;
        if ( ! empty($carts)) {
            foreach ($carts as $cart) {
                $countProduct += $cart['quantity'];
            }
        }

        return $countProduct;
    }

    private function _sumCart($carts)
    {
        $total = 0;
        if ( ! empty($carts)) {
            foreach ($carts as $cart) {
                $total += $cart['quantity'] * ($cart['price']
                        + $cart['total_options']);
            }
        }

        return $total;
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

    /**
     * checkComeback to show popup
     *
     * @return \Cake\Http\Response|null
     */
    public function checkComeback()
    {
        $settingInfo = $this->_getConfigs();
        $currentTime = date('H:i');
        if ($settingInfo['time_open'] > $currentTime
            || $currentTime > $settingInfo['time_close']
        ) {
            $amPm = date('A', strtotime($settingInfo['time_open']));
            $this->Flash->greatMessage(__(MSG_SERVICE_COMEBACK,
                    $settingInfo['time_open']) . ' ' . __($amPm));

            $language = I18n::getLocale();

            return $this->redirect('/' . $language);
        }
    }

    public function checkComebackAjax()
    {
        $settingInfo = $this->_getConfigs();
        $currentTime = date('H:i');
        $back        = false;
        if ($settingInfo['time_open'] > $currentTime
            || $currentTime > $settingInfo['time_close']
        ) {
            $back = true;
        }

        return $back;
    }

    public function returnAjax($data)
    {
        $this->response->type('json');
        $this->response->body(json_encode($data));

        return $this->response;
    }

    protected function _sendMailOrder($to, $data = [])
    {
        $invoiceLink = Router::url([
            'controller' => 'Invoices',
            'action'     => 'view',
            '?'          => [
                'request' => base64_encode($data['order_id']),
                'key'     => md5($data['tracking_number']),
            ],
        ], true);

        /* @var \App\Model\Table\MailTemplatesTable $mailObj */
        $mailObj = TableRegistry::get('MailTemplates');
        $mail    = $mailObj->getMailTemplate(MAIL_TEMPLATE_ORDER);
        $pattern = ['/\%link\%/'];
        $replace = [$invoiceLink];
        $content = preg_replace($pattern, $replace, $mail['content']);
        $subject = str_replace('%order%', $data['tracking_number'],
            $mail['subject']);

        $config = $this->_getConfigs();
        $cc     = explode(',', $config['site_mail_order_receipt']);
        if ($to == '' && ! empty($cc[0])) {
            $to = $cc[0];
            unset($cc[0]);
        }
        if ( ! empty($to)) {
            $mailObj->sendMail($subject, $content, $to,
                ['userInfo' => $data], 'html', 'gmail', null, 'order', 'order',
                $cc);
        }
    }

    protected function deleteCart()
    {
        $session = $this->request->getSession();
        $session->delete('cart');
        $session->delete('payment');
        $session->delete('orders');
        $session->delete('feeship');
    }

    /**
     * @param $type
     * @param $value
     * @param $total
     *
     * @return int
     */
    public function getPriceDiscount($type, $value, $total)
    {
        if (in_array($type, [VOUCHER_PERCENT, VOUCHER_PRICE])) {
            $price       = ($type == VOUCHER_PERCENT) ? (int)($value / 100
                * $total) : $value;
            $session     = $this->request->getSession();
            $feeShipping = empty($session->read('feeship')) ? 0
                : $session->read('feeship');

            return ($price >= $feeShipping) ? $feeShipping : $price;
        }

        return 0;
    }
}