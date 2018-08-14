<?php

namespace App\View\Helper;

use Cake\I18n\Number;
use Cake\I18n\Time;
use Cake\View\Helper;
use Cake\View\View;
use Cake\Core\Configure;

class UtilityHelper extends Helper
{

    public $helpers = ['Html', 'Form'];

    protected static $_excludePermission
        = [
            'login',
            'summary',
            'logout',
        ];

    // initialize() hook is available since 3.2. For prior versions you can
    // override the constructor if required.
    public function initialize(array $config)
    {
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
     * Build menu admin with one level
     *
     * @param $arrMenus
     * @param $activeAction
     *
     * @return null|string
     */
    public function buildMenuAdmin(
        $arrMenus,
        $activeAction
    ) {
        $html = null;

        foreach ($arrMenus as $menu) {
            $url       = ! empty($menu['url']) ? $menu['url'] : [];
            $active    = ($activeAction === $url
                || ( ! empty($url['controller'])
                    && ($activeAction['controller'] == $url['controller'])))
                ? 'active'
                : '';
            $subActive = '';

            // with case click submenu then parent class is active
            if ( ! empty($menu['child'])) {
                foreach ($menu['child'] as $child) {
                    if ($activeAction === $child['url']
                        || ( ! empty($child['url']['controller'])
                            && ($activeAction['controller']
                                == $child['url']['controller']))
                    ) {
                        $subActive = 'active';
                        break;
                    }
                }
            }

            $html .= '<li class="' . $active . ' ' . $subActive . '">';
            $html .= $this->Html->link(
                '<i class="' . $menu['icon'] . '"></i><span class="nav-label">'
                . __($menu['title']) . '</span>', $url, ['escapeTitle' => false]
            );

            if ( ! empty($menu['child'])) {
                // only support build menu level 1
                $colIn = ! empty($subActive) ? 'in' : '';
                $html  .= '<ul class="nav nav-second-level collapse ' . $colIn
                    . '">';

                foreach ($menu['child'] as $child) {
                    $menuActive = ($activeAction === $child['url']
                        || ( ! empty($child['url']['controller'])
                            && ($activeAction == $child['url'])))
                        ? 'active'
                        : '';

                    $subLink = $this->Html->link(__($child['title']),
                        $child['url']);
                    $html    .= '<li class="' . $menuActive . '">' . $subLink
                        . '</li>';
                }
                $html .= '</ul>';
            }
            $html .= '</li>';
        }

        return $html;
    }

    /**
     * @param      $arrMenus
     * @param      $currentUserPermissions
     * @param bool $isAdmin
     *
     * @return array
     */
    public function formatDataWithPermission(
        $arrMenus,
        $currentUserPermissions,
        $isAdmin = false
    ) {
        $permissions = Configure::read('permissions');
        $result      = [];

        foreach ($arrMenus as $menu) {
            $url = ! empty($menu['url']) ? $menu['url'] : [];

            if ( ! $isAdmin) {
                // check permission with level one
                $codeParent = ! empty($url['controller'])
                && ! empty($url['action'])
                && ! empty($permissions[$url['controller']][$url['action']])
                    ? $permissions[$url['controller']][$url['action']] : '';

                if ( ! empty($menu['url'])
                    && ! in_array($url['action'], self::$_excludePermission)
                    && empty($currentUserPermissions[$codeParent])
                ) {
                    continue;
                }
            }

            if ( ! empty($menu['child'])) {
                $childArr = [];
                foreach ($menu['child'] as $child) {
                    $urlChild = $child['url'];
                    if ( ! $isAdmin) {
                        $code = ! empty($urlChild['controller'])
                        && ! empty($urlChild['action'])
                        && ! empty($permissions[$urlChild['controller']][$urlChild['action']])
                            ? $permissions[$urlChild['controller']][$urlChild['action']]
                            : '';

                        if ( ! in_array($urlChild['action'],
                                self::$_excludePermission)
                            && empty($currentUserPermissions[$code])
                        ) {
                            continue;
                        }
                    }

                    $childArr[] = $child;
                }

                if ( ! empty($childArr)) {
                    $menu['child'] = $childArr;
                } else {
                    $menu['child'] = [];
                }
            }

            if ( ! empty($menu['url']) || ! empty($menu['child'])) {
                $result[] = $menu;
            }
        }

        return $result;
    }

    /**
     * Custom template form
     *
     * @return array
     */
    public function customFormTemplate()
    {
        $url        = ['action' => 'index'];
        $session    = $this->request->getSession();
        $controller = $this->request->getParam('controller');
        $userId     = $session->read('Auth.User.id');
        $params     = $session->read('Link.' . $userId . $controller);
        if ( ! empty($params)) {
            $url['?'] = $params;
        }

        $backLink = $this->Html->link(
            __(BACK), $url, [
                'class' => 'btn btn-white m-b pull-right',
            ]
        );

        return [
            'label'               => '<label class="col-sm-2 control-label">{{text}}</label>',
            'formGroup'           => '<div class="form-group">{{label}}<div class="col-sm-10">{{input}}{{error}}</div></div>',
            'submitContainer'     => '<div class="form-group row"><div class="col-sm-2"></div>
                                <div class="col-sm-10">{{content}} ' . $backLink
                . '</div></div>',
            'inputContainerError' => '<div class="input {{type}}{{required}} error">{{content}}</div>',
        ];
    }

    /**
     * build menu pages
     *
     * @param       $menus
     * @param null  $activeAction
     * @param array $urlMain
     * @param null  $clsUl
     *
     * @return string
     */
    public function buildMenu(
        $menus,
        $activeAction = null,
        $urlMain = [],
        $clsUl = null
    ) {
        $clsul = empty($clsUl) ? "" : $clsUl;
        $html  = "<ul class=\"{$clsul}\">";

        foreach ($menus as $menu) {
            $url     = ! empty($menu["url"]) ? $menu["url"] : [];
            $active  = $activeAction[0] === $url ? "active" : "";
            $urlLink = empty($urlMain)
                ? '/'
                : $urlMain['controller'] . '/' . $urlMain['action'] . '/'
                . $menu->url;
            $key     = $this->Html->link($menu->name, $urlLink);
            $clsLi   = $submenu = "";
            if ( ! empty($menu['children'])) {
                $key     = $this->Html->link($menu->name
                    . "<span class=\"fa fa-caret-down\"></span>",
                    $url, ["escape" => false]);
                $clsLi   = "dropdown-submenu";
                $submenu .= $this->buildMenu($menu["children"], $activeAction,
                    $urlMain,
                    "submenu dropdown-menu");
            }
            $html .= "<li class=\"{$clsLi} {$active}\">{$key}" . $submenu;
        }
        $html .= "</li></ul>";

        return $html;
    }

    /**
     * @param      $number
     * @param bool $isDisplay
     *
     * @return int|string
     */
    public function formatPrice($number, $isDisplay = false)
    {
        $textDisplay = $isDisplay ? 0 : 'Liên hệ';

        return ! empty($number) ? number_format($number, 0, '.', ',') . ' đ'
            : $textDisplay;
    }

    /**
     *
     * array time from start to end by distance
     *
     * @param null   $distance
     * @param string $start
     * @param string $end
     *
     * @return array
     */
    public function convertMinutesToHours(
        $distance = null,
        $start = TIME_START_TEXT,
        $end = TIME_END_TEXT
    ) {
        $arrTime            = [];
        $arrTime[SOON_TIME] = SOON_TIME;
        $distance           = empty($distance) ? TIME_DISTANCE : $distance;
        $start              = explode(":", $start);
        $end                = explode(":", $end);
        $start              = ($start[0] * 60) + $start[1];
        $end                = ($end[0] * 60) + $end[1];

        for ($mins = $start; $mins <= $end; ($mins += $distance)) {
            $hours         = floor($mins / 60);
            $minutes       = $mins - ($hours * 60);
            $H_i           = str_pad($hours, '2', '0', STR_PAD_LEFT);
            $H_i           .= ':' . str_pad($minutes, '2', '0', STR_PAD_LEFT);
            $arrTime[$H_i] = $H_i;
        }

        return $arrTime;
    }

    /**
     * generate html address
     *
     * @param        $arrayAddress
     * @param string $content
     * @param bool   $form
     * @param array  $option
     *
     * @return string
     */
    public function generateAddress(
        $arrayAddress,
        $content = "",
        $form = false,
        $option = []
    ) {
        $html = "";
        foreach ($arrayAddress as $add) {
            $address = $add['address'];
            $htmlAdd = "";
            $url     = isset($option['link']['url'])
                ? array_merge($option['link']['url'], ['action' => 'add']) : [];
            if ( ! empty($address)) {
                if ($form) {
                    foreach ($address as $key => $value) {
                        $options = [
                            'class'    => 'form-control',
                            'disabled' => true,
                            'value'    => $value,
                        ];
                        $options = ($key === 'typeContact')
                            ? array_merge(['options' => $option[$key]],
                                $options) : $options;
                        $htmlAdd .= $this->Form->control($key, $options);
                    }
                } else {
                    $valueAddress = $valueContact = "";
                    if ($address['typeContact'] == PHONE
                        && ! empty($address['valueContact'])
                    ) {
                        $valueContact = __('Phone: ')
                            . $address['valueContact'];
                    }
                    if ($address['typeAddress'] == HOTEL) {
                        $room         = empty($address['room']) ? ""
                            : __(CHECKOUT_NUM_ROOM) . " " . $address['room'];
                        $valueAddress = implode(', ', array_filter([
                            $room,
                            $add['hotel']['name'],
                            $add['hotel']['address'],
                        ]));
                    } elseif ($address['typeAddress'] == HOUSE) {
                        $valueAddress = implode(', ', array_filter([
                            $address['numHouse'],
                            __($add['address']['areaOrder']) . "<br/>"
                            . __(CHECKOUT_NOTE_INPUT) . ": "
                            . $address['houseNote'],
                        ]));
                    }
                    $addInfo = [
                        __('Name: ') . $address['fullname'],
                        $valueContact,
                        $valueAddress,
                    ];
                    $htmlAdd = "<p>" . implode('</p><p>',
                            array_filter($addInfo)) . "</p>";
                    $url     = isset($option['link']['url'])
                        ? array_merge($option['link']['url'],
                            ['action' => 'edit', $address['id']])
                        : [];
                }
            } else {
                $url['?'] = [
                    'prefix' => $add['prefix'],
                    'type'   => DEFAULT_ADDRESS,
                ];
            }
            $class   = isset($add['class']) ? $add['class'] : "";
            $link    = isset($option['link']['title'])
                ? $this->Html->link(__($option['link']['title']), $url) : "";
            $pattern = [
                '/\%title\%/',
                '/\%htmlAdd\%/',
                '/\%class\%/',
                '/\%link\%/',
            ];
            $replace = [$add['title'], $htmlAdd, $class, $link,];
            $html    .= preg_replace($pattern, $replace, $content);
        }

        return $html;
    }


    /**
     * format and calculate price
     *
     * @param        $prices
     * @param bool   $calculate
     * @param bool   $calDiscount
     * @param string $unit
     *
     * @return array|int|string
     */
    public function formatAndCalcPrice(
        $prices,
        $calculate = false,
        $calDiscount = false,
        $unit = CURRENCY_UNIT
    ) {
        //calculate total order
        if ($calculate) {
            $arrays = [
                'subTotal'    => empty($prices['subTotal']) ? 0
                    : $prices['subTotal'],
                'feeShipping' => empty($prices['feeShipping']) ? 0
                    : $prices['feeShipping'],
                'discount'    => 0,
            ];

            if ( ! empty($prices['discount'])) {
                $discount           = ($arrays['subTotal']
                        * $prices['discount']) / 100;
                $arrays['discount'] = $discount;
            }
            $total           = ($arrays['subTotal'] - $arrays['discount'])
                + $arrays['feeShipping'];
            $arrays['total'] = $total;
            $prices          = $arrays;
        }
        //calculate discount price each item
        if ($calDiscount) {
            $arrays             = [
                'price'    => empty($prices['price']) ? 0
                    : $prices['price'],
                'quantity' => empty($prices['quantity']) ? 0
                    : $prices['quantity'],
                'total'    => empty($prices['total']) ? 0
                    : $prices['total'],
            ];
            $discount           = ($arrays['price'] * $arrays['quantity'])
                - $arrays['total'];
            $arrays['discount'] = $discount;
            unset($arrays['quantity']);
            $prices = $arrays;
        }

        if (is_array($prices)) {
            if ($unit != false) {
                $arr = [];
                foreach ($prices as $key => $price) {
                    $arr[$key] = Number::format($price, ['after' => $unit]);
                }

                return $arr;
            }

            return $prices;
        }

        $prices = empty($prices) ? 0 : $prices;

        return Number::format($prices, ['after' => $unit]);
    }

    public function checkPercent($number)
    {
        $number  = (int)$number;
        $percent = '<i class="fa fa-bolt"></i>';
        if ($number > 0) {
            $percent = '<i class="fa fa-level-up"></i>';
        } else if ($number < 0) {
            $percent = '<i class="fa fa-level-down"></i>';
        }

        return $percent;
    }

    /**
     * generate table report
     *
     * @param array  $heads
     * @param string $bodys
     *
     * @return string
     */
    public function generateTableReport($heads = [], $bodys = "")
    {
        $html     = "<table class=\"table table-bordered toggle-arrow-tiny\">";
        $headRow2 = $headRow1 = '';
        foreach ($heads as $head) {
            $colspan = 0;
            $rowspan = ! empty($head['rowspan']) ? $head['rowspan'] : "";
            if ( ! empty($head['colspan'])) {
                foreach ($head['colspan'] as $td) {
                    $colspan++;
                    $headRow2 .= "<th>" . $td . "</th>";
                }
            }
            $colspan = $colspan !== 0 ? $colspan : "";
            $headRow1 .= "<th class=\"{$head['class']}\" colspan=\"{$colspan}\" rowspan=\"{$rowspan}\">"
                . __($head['title']) . "</th>";
        }
        $headRow1 = "<tr>{$headRow1}</tr>";
        $headRow1 .= empty($head['colspan']) ? $headRow2
            : "<tr>{$headRow2}</tr>";
        $html     .= "<thead>{$headRow1}</thead><tbody>{$bodys}</tbody></table>";

        return $html;
    }
}