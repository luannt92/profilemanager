<?php
$arrMenus = [
    [
        'icon'  => 'fa fa-dashboard',
        'title' => 'Dashboard',
        'url'   => ['controller' => 'Users', 'action' => 'dashboard'],
    ],
    [
        'icon'  => 'fa fa-shopping-cart',
        'title' => 'Store',
        'child' => [
            [
                'icon'  => 'fa fa-newspaper-o',
                'title' => 'Catalogue',
                'url'   => ['controller' => 'News', 'action' => 'index'],
            ],
            [
                'icon'  => 'fa fa-newspaper-o',
                'title' => 'Products list',
                'url'   => ['controller' => 'News', 'action' => 'index'],
            ],
            [
                'icon'  => 'fa fa-th',
                'title' => 'Orders list',
                'url'   => ['controller' => 'Categories', 'action' => 'index'],
            ],
            [
                'icon'  => 'fa fa-tags',
                'title' => 'Customers',
                'url'   => ['controller' => 'Tags', 'action' => 'index'],
            ],
        ],
    ],
    [
        'icon'  => 'fa fa-sitemap',
        'title' => 'Website',
        'child' => [
            [
                'icon'  => 'fa fa-suitcase',
                'title' => 'Page',
                'url'   => ['controller' => 'Pages', 'action' => 'index'],
            ],
            [
                'icon'  => 'fa fa-check-square-o',
                'title' => 'Menus',
                'url'   => ['controller' => 'Menus', 'action' => 'index'],
            ],
            [
                'icon'  => 'fa fa-suitcase',
                'title' => 'Service',
                'url'   => ['controller' => 'Pages', 'action' => 'index'],
            ],
            [
                'icon'  => 'fa fa-suitcase',
                'title' => 'Slider',
                'url'   => ['controller' => 'Pages', 'action' => 'index'],
            ],
            [
                'icon'  => 'fa fa-suitcase',
                'title' => 'Mail template',
                'url'   => ['controller' => 'Pages', 'action' => 'index'],
            ],
        ],
    ],
    [
        'icon'  => 'fa fa-bar-chart-o',
        'title' => ' Reports',
        'child' => [
            [
                'icon'  => 'fa fa-newspaper-o',
                'title' => 'Sales Report',
                'url'   => ['controller' => 'News', 'action' => 'index'],
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
            [
                'title' => 'Permissions',
                'url'   => ['controller' => 'UserGroups', 'action' => 'add'],
            ],

        ],
    ],
    [
        'icon'  => 'fa fa-gear',
        'title' => 'Settings',
        'child' => [
            [
                'title' => 'Payment Processors',
                'url'   => ['controller' => 'Users', 'action' => 'index'],
            ],
            [
                'title' => 'Order Statuses',
                'url'   => ['controller' => 'UserGroups', 'action' => 'index'],
            ],
            [
                'title' => 'Shipping Methods',
                'url'   => ['controller' => 'UserGroups', 'action' => 'add'],
            ],
            [
                'title' => 'Emails',
                'url'   => ['controller' => 'UserGroups', 'action' => 'add'],
            ],

        ],
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
            <?php echo $this->Utility->buildMenuAdmin($arrMenus,
                $activeAction); ?>
        </ul>
    </div>
</nav>
