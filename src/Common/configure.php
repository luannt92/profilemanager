<?php

use \Cake\Core\Configure;

Configure::write('system_status', [
    TRASH           => ['name' => 'Trash', 'class' => 'label-danger'],
    DISABLED        => ['name' => 'Disabled', 'class' => 'label-warning'],
    ENABLED         => ['name' => 'Enabled', 'class' => 'label-success'],
    REGISTER_STATUS => ['name' => 'Register', 'class' => 'label-info'],
    CLOSED          => ['name' => 'Closed', 'class' => 'label-danger'],
    PENDING         => ['name' => 'Pending', 'class' => 'label-primary'],
]);

Configure::write('system_languages', [
    'vi' => 'Vietnamese',
]);

Configure::write('status', [
    ENABLED         => 'Enabled',
    DISABLED        => 'Disabled',
    TRASH           => 'Trash',
    REGISTER_STATUS => 'Register',
]);

Configure::write('group_types', [
    SUPER_ADMIN => 'Super Administrator',
    ADMIN       => 'Administrator',
    MEMBER      => 'Member',
]);

Configure::write('gender', [
    MALE   => 'Male',
    FEMALE => 'Female',
]);

Configure::write('type_pages', [
    INTRODUCE => 'Introduce',
]);

Configure::write('type_menu', [
    MENU_HEADER => 'Menu header',
    MENU_FOOTER => 'Menu footer',
    MENU_LINK   => 'Menu link',
]);

Configure::write('flot_bys', [
    FLOT_DAY    => [
        'format' => 'Y-m-d',
        'now'    => 'this day',
        'last'   => '-1 day',
        'last2'  => '-2 day',
        'last3'  => '-3 day',
    ],
    FLOT_MONTH  => [
        'format' => 'm',
        'now'    => 'this month',
        'last'   => 'last day of -1 month',
        'last2'  => 'last day of -2 month',
        'last3'  => 'last day of -3 month',
    ],
    FLOT_ANNUAL => [
        'format' => 'Y',
        'now'    => 'this year',
        'last'   => '-1 year',
        'last2'  => '-2 year',
        'last3'  => '-3 year',
    ],
]);

Configure::write('slider_types', [
    SLIDER_IMAGE => [
        'title' => 'Image',
        'class' => 'fa fa-photo',
    ],
    SLIDER_VIDEO => [
        'title' => 'Video',
        'class' => 'fa fa-video-camera',
    ],
]);