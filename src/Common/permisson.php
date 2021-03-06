<?php

use \Cake\Core\Configure;

Configure::write('permissions', [
    'Categories'     => [
        'index'          => 100,
        'view'           => 101,
        'add'            => 102,
        'edit'           => 103,
        'delete'         => 104,
        'deleteSelected' => 105,
    ],
    'MailTemplates'  => [
        'index'          => 400,
        'view'           => 401,
        'add'            => 402,
        'edit'           => 403,
        'deleteSelected' => 405,
    ],
    'Menus'          => [
        'index'          => 500,
        'add'            => 501,
        'edit'           => 502,
        'deleteSelected' => 505,
    ],
    'NewCategories'  => [
        'index'          => 600,
        'view'           => 601,
        'add'            => 602,
        'edit'           => 603,
        'delete'         => 604,
        'deleteSelected' => 605,
    ],
    'News'           => [
        'index'          => 700,
        'view'           => 701,
        'add'            => 702,
        'edit'           => 703,
        'delete'         => 704,
        'deleteSelected' => 705,
    ],
    'Orders'         => [
        'index'          => 800,
        'view'           => 801,
        'add'            => 802,
        'edit'           => 803,
        'delete'         => 804,
        'deleteSelected' => 805,
        'invoice'        => 806,
        'invoicePrint'   => 807,
    ],
    'OurServices'    => [
        'index'          => 900,
        'view'           => 901,
        'add'            => 902,
        'edit'           => 903,
        'delete'         => 904,
        'deleteSelected' => 905,
    ],
    'Pages'          => [
        'index'          => 1000,
        'view'           => 1001,
        'add'            => 1002,
        'edit'           => 1003,
        'delete'         => 1004,
        'deleteSelected' => 1005,
    ],
    'Settings'       => [
        'update' => 1400,
    ],
    'Sliders'        => [
        'index'          => 1700,
        'view'           => 1701,
        'add'            => 1702,
        'edit'           => 1703,
        'delete'         => 1704,
        'deleteSelected' => 1705,
    ],
    'Stores'         => [
        'index'          => 1800,
        'view'           => 1801,
        'add'            => 1802,
        'edit'           => 1803,
        'delete'         => 1804,
        'deleteSelected' => 1805,
    ],
    'Users'          => [
        'index'          => 2000,
        'view'           => 2001,
        'add'            => 2002,
        'edit'           => 2003,
        'delete'         => 2004,
        'deleteSelected' => 2005,
    ],
    'UserGroups'     => [
        'index'          => 2100,
        'view'           => 2101,
        'add'            => 2102,
        'edit'           => 2103,
        'delete'         => 2104,
        'deleteSelected' => 2105,
    ],
    'Dashboards'     => [
        'report'      => 2200,
        'customer'    => 2201,
        'profit'      => 2202,
        'reportOrder' => 2203,
    ],
]);
