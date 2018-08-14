<?php
$arrMenus = [
    [
        'icon'  => 'fa fa-dashboard',
        'title' => 'Dashboard',
        'url'   => ['controller' => 'Dashboards', 'action' => 'summary'],
    ],
    [
        'icon'  => 'fa fa-shopping-cart',
        'title' => 'Store',
        'child' => [
            [
                'title' => 'Services',
                'url'   => [
                    'controller' => 'Services',
                    'action'     => 'index',
                ],
            ],
            [
                'title' => 'Category',
                'url'   => [
                    'controller' => 'Categories',
                    'action'     => 'index',
                ],
            ],
            [
                'title' => 'Stores',
                'url'   => [
                    'controller' => 'Stores',
                    'action'     => 'index',
                ],
            ],
            [
                'title' => 'Product',
                'url'   => [
                    'controller' => 'Products',
                    'action'     => 'index',
                ],
            ],
            [
                'icon'  => 'fa fa-th',
                'title' => 'Orders',
                'url'   => ['controller' => 'Orders', 'action' => 'index'],
            ],
            [
                'icon'  => 'fa fa-th',
                'title' => 'Vouchers',
                'url'   => ['controller' => 'Discounts', 'action' => 'index'],
            ],
            [
                'icon'  => 'fa fa-th',
                'title' => 'Promotions',
                'url'   => ['controller' => 'Promotions', 'action' => 'index'],
            ],
        ],
    ],
    [
        'icon'  => 'fa fa-bicycle',
        'title' => 'Shipping',
        'child' => [
            [
                'icon'  => 'fa fa-tags',
                'title' => 'Shipping zones',
                'url'   => [
                    'controller' => 'ShippingZones',
                    'action'     => 'index',
                ],
            ],
            [
                'icon'  => 'fa fa-tags',
                'title' => 'Shipper',
                'url'   => ['controller' => 'Shippers', 'action' => 'index'],
            ],
            [
                'icon'  => 'fa fa-tags',
                'title' => 'Hotels',
                'url'   => ['controller' => 'Hotels', 'action' => 'index'],
            ],
        ],
    ],
    [
        'icon'  => 'fa fa-bar-chart-o',
        'title' => ' Reports',
        'child' => [
            [
                'icon'  => 'fa fa-newspaper-o',
                'title' => 'Report',
                'url'   => ['controller' => 'Dashboards', 'action' => 'report'],
            ],
            [
                'icon'  => 'fa fa-newspaper-o',
                'title' => 'Profit',
                'url'   => ['controller' => 'Dashboards', 'action' => 'reportShipping'],
            ],
            [
                'icon'  => 'fa fa-newspaper-o',
                'title' => 'Customer',
                'url'   => [
                    'controller' => 'Dashboards',
                    'action'     => 'customer',
                ],
            ],
            [
                'icon'  => 'fa fa-newspaper-o',
                'title' => 'Zone',
                'url'   => ['controller' => 'Dashboards', 'action' => 'zone'],
            ],
            [
                'icon'  => 'fa fa-newspaper-o',
                'title' => 'Shipper',
                'url'   => ['controller' => 'Dashboards', 'action' => 'shipper'],
            ],
            [
                'icon'  => 'fa fa-newspaper-o',
                'title' => 'User Logs',
                'url'   => ['controller' => 'UserLogs', 'action' => 'index'],
            ],
             [
                'icon'  => 'fa fa-newspaper-o',
                'title' => 'Order History',
                'url'   => ['controller' => 'OrderHistories', 'action' => 'index'],
            ],
            [
                'icon'  => 'fa fa-newspaper-o',
                'title' => 'User Trackings',
                'url'   => ['controller' => 'UserTrackings', 'action' => 'index'],
            ],
        ],
    ],
    [
        'icon'  => 'fa fa-sitemap',
        'title' => 'Website',
        'child' => [
            [
                'title' => 'Page',
                'url'   => ['controller' => 'Pages', 'action' => 'index'],
            ],
            [
                'title' => 'Menus',
                'url'   => ['controller' => 'Menus', 'action' => 'index'],
            ],
            [
                'title' => 'Our Services',
                'url'   => ['controller' => 'OurServices', 'action' => 'index'],
            ],
            [
                'title' => 'Slider',
                'url'   => ['controller' => 'Sliders', 'action' => 'index'],
            ],
            [
                'title' => 'Mail template',
                'url'   => [
                    'controller' => 'MailTemplates',
                    'action'     => 'index',
                ],
            ],
            [
                'title' => 'Countries',
                'url'   => [
                    'controller' => 'Countries',
                    'action'     => 'index',
                ],
            ],
            [
                'title' => 'Support',
                'url'   => ['controller' => 'Supports', 'action' => 'index'],
            ],
            [
                'title' => 'Payment Method',
                'url' => ['controller' => 'PaymentMethods', 'action' => 'index']
            ]
        ],
    ],
    [
        'icon'  => 'fa fa-newspaper-o',
        'title' => 'News',
        'child' => [
            [
                'title' => 'List',
                'url'   => ['controller' => 'News', 'action' => 'index'],
            ],
            [
                'title' => 'Categories',
                'url'   => [
                    'controller' => 'NewCategories',
                    'action'     => 'index',
                ],
            ],
            [
                'title' => 'Tags',
                'url'   => ['controller' => 'Tags', 'action' => 'index'],
            ],
        ],
    ],
    [
        'icon'  => 'fa fa-users',
        'title' => 'Members',
        'child' => [
            [
                'title' => 'Members',
                'url'   => ['controller' => 'Users', 'action' => 'index'],
            ],
            [
                'title' => 'User Groups',
                'url'   => ['controller' => 'UserGroups', 'action' => 'index'],
            ],
        ],
    ],
    [
        'icon'  => 'fa fa-gear',
        'title' => 'Settings',
        'url'   => ['controller' => 'Settings', 'action' => 'update '],
    ],
];

$activeAction = [
    'controller' => $this->request->getParam('controller'),
    'action'     => $this->request->getParam('action'),
];

$userInfo = $this->request->session()->read('Auth.User');
?>
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="text-muted text-xs block">
                                <?php echo $userInfo['full_name']; ?>
                            </span>
                        </span>
                    </a>
                </div>
                <div class="logo-element">
                    <h3 style="font-size: 13px;">PQD</h3>
                </div>
            </li>
            <?php
            $arrMenus = $this->Utility->formatDataWithPermission($arrMenus,
                $currentUserPermissions, $isAdmin);
            echo $this->Utility->buildMenuAdmin($arrMenus, $activeAction); ?>
        </ul>
    </div>
</nav>
