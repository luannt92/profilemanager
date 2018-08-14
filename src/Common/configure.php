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
//    SUPER_ADMIN => 'Super Administrator',
ADMIN    => 'Administrator',
CENTER   => 'Center',
DELIVERY => 'Delivery',
MEMBER   => 'Member',
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

Configure::write('layout_service', [
    LAYOUT_SERVICE => 'Service',
    LAYOUT_STORE   => 'Store',
]);

Configure::write('payment_method', [
    PAYMENT_CASH_ON_DELIVERY     => 'Cash on Delivery',
    PAYMENT_PAYPAL               => 'PayPal',
    PAYMENT_DIRECT_BANK_TRANSFER => 'Direct Bank transfer',
]);

Configure::write('contact_types', [
    PHONE    => PHONE_TEXT,
    WHATSAPP => WHATSAPP_TEXT,
    VIBER    => VIBER_TEXT,
    ZALO     => ZALO_TEXT,
]);

Configure::write('address_types', [
    HOTEL => HOTEL_TEXT,
    HOUSE => HOUSE_TEXT,
]);

Configure::write('type_layout', [
    LAYOUT_GRID => 'grid',
    LAYOUT_LIST => 'list',
]);

Configure::write('status_order', [
    CANCEL     => ['name' => 'Hủy', 'class' => 'cancel'],
    PROCESSING => ['name' => 'Đang xử lý', 'class' => 'processing'],
    CONFIRMED  => ['name' => 'Xác nhận', 'class' => 'confirmed'],
    SHIPPED    => ['name' => 'Đã chuyển đến', 'class' => 'shipped'],
    RECEIVED   => ['name' => 'Đã nhận hàng', 'class' => 'received'],
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

Configure::write('product_type', [
    PRODUCT_TYPE_NORMAL => "Simple product",
    PRODUCT_TYPE_EXTRA  => "Variable product",
]);

Configure::write('product_option_type', [
    PRODUCT_OPTION_TYPE_SELECTBOX => "Select",
    PRODUCT_OPTION_TYPE_CHECKBOX  => "Checkbox",
]);

Configure::write('icon_menu_child', [
    'ser-img1' => 'Nhà hàng',
    'ser-img2' => 'Siêu thị',
    'ser-img3' => 'Hiệu thuốc',
    'ser-img4' => 'Đặc sản',
]);

Configure::write('paid', [
    '0' => 'Unpaid',
    '1' => 'Paid',
]);

Configure::write('mode', [
    SHIPPER_KEY => 'Shippers',
    USER_KEY    => 'Users',
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

Configure::write('shipping_zone', [
    'Zone Red'    => 'Zone Red',
    'Zone Green'  => 'Zone Green',
    'Zone Blue'   => 'Zone Blue',
    'Zone Yellow' => 'Zone Yellow',
    'Zone Orange' => 'Zone Orange',
]);

Configure::write('store_hour', [
    'Monday'    => '2',
    'Tuesday'   => '3',
    'Wednesday' => '4',
    'Thursday'  => '5',
    'Friday'    => '6',
    'Saturday'  => '7',
    'Sunday'    => '8',
]);

Configure::write('text_day', [
    '2' => 'Monday',
    '3' => 'Tuesday',
    '4' => 'Wednesday',
    '5' => 'Thursday',
    '6' => 'Friday',
    '7' => 'Saturday',
    '8' => 'Sunday',
]);

Configure::write('voucher_type', [
    VOUCHER_PRICE  => "Price",
//    VOUCHER_PERCENT => "Percent",
]);

Configure::write('time_sale', [
    '1' => 'Day',
    '2' => 'Morning',
    '3' => 'Night',
]);
