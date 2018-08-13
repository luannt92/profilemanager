<?php

use \Cake\Core\Configure;

Configure::write('system_status', [
    TRASH           => ['name' => 'Trash', 'class' => 'label-danger'],
    DISABLED        => ['name' => 'Disabled', 'class' => 'label-warning'],
    ENABLED         => ['name' => 'Enabled', 'class' => 'label-success'],
    REGISTER_STATUS => ['name' => 'Register', 'class' => 'label-info'],
]);

Configure::write('status', [
    ENABLED         => 'Enabled',
    DISABLED        => 'Disabled',
    TRASH           => 'Trash',
    REGISTER_STATUS => 'Register',
]);

Configure::write('group_types', [
    ADMIN       => 'administrator',
    SUBSCRIBER  => 'subscriber',
    AUTHOR      => 'author',
    EDITOR      => 'editor',
    CONTRIBUTOR => 'contributor',
    CONTENT     => 'content',
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
]);

Configure::write('status_tour', [
    TRASH   => ['name' => 'Trash', 'class' => 'label-danger'],
    REFUSE  => ['name' => 'Refuse', 'class' => 'label-warning'],
    CONFIRM => ['name' => 'Confirm', 'class' => 'label-success'],
    PENDING => ['name' => 'Pending', 'class' => 'label-info'],
]);
