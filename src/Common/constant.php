<?php
/* prefix  */
define('TABLE_PREFIX', 'ntl_');
define('DOMAIN', 'http://nguyenluan.net/');

/* Status */
define('ENABLED', 1);
define('CONFIRM', 1);
define('DISABLED', 0);
define('TRASH', -1);
define('REGISTER_STATUS', 2);
define('PENDING', 2);
define('CLOSED', 3);
define('ACTIVE', 1);
define('DEACTIVE', 0);

define('REMOVE_RECORD', 100);

define('FLOT_DAY', 1);
define('FLOT_MONTH', 2);
define('FLOT_ANNUAL', 3);

/* Group */
define('SUPER_ADMIN', 99);
define('ADMIN', 1);
define('MEMBER', 2);

/* Gender */
define('MALE', 1);
define('FEMALE', 0);

/* Min length */
define('MIN_LENGTH_USERNAME', 6);
define('MIN_LENGTH_PASSWORD', 6);

/* Default language */
define('VI_VN', 1);

define('NO_IMAGE', 'https://via.placeholder.com/280x158.jpg');

define('DEFAULT_LIMIT', 20);

/* user type */
define('FREE_TYPE', 1);

/* menu */
define('MENU', 1);
define('TYPE_CATEGORY', 2);
define('TYPE_TAG', 4);
define('TYPE_PAGE', 3);
define('TYPE_LINK', 5);
define('TYPE_NEW_CATEGORY', 6);

/* menu type */
define('MENU_HEADER', 1);
define('MENU_FOOTER', 2);
define('MENU_LINK', 3);

/* menu cache */
define('CACHE_MENU', 'menu');

/* Page type */
define('INTRODUCE', 0);

/*Email*/
define('MAIL_TEMPLATE_REGISTER', 'TPL0001');
define('MAIL_TEMPLATE_FORGOT_PASSWORD', 'TPL0002');
define('MAIL_TEMPLATE_RESET_FORGOT_PASSWORD', 'TPL0003');
define('MAIL_TEMPLATE_REGISTER_SUCCESS', 'TPL0004');
define('MAIL_TEMPLATE_ORDER', 'TPL0005');
define('MAIL_TEMPLATE_CONTACT', 'TPL0006');
define('MAIL_TEMPLATE_UPDATE_STATUS_ORDER', 'TPL0007');
define('MAIL_TEMPLATE_BIRTHDAY', 'TPL0008');
define('MAIL_TEMPLATE_ADD_SHIPPER', 'TPL0009');
define('MAIL_TEMPLATE_CHANGE_ORDER_STATUS', 'TPL0010');

define('MAIL_TEMPLATE_REGISTER_API', 'TPLA0001');
define('MAIL_TEMPLATE_FORGOT_PASSWORD_API', 'TPLA0002');
define('MAIL_TEMPLATE_CHANGE_ORDER_STATUS_API', 'TPLA0010');


/* Address */
define('DEFAULT_ADDRESS', 1);
define('SELECT_ADDRESS', 2);
define('RECIPIENT_ADDRESS', 1);
define('PAYMENT_ADDRESS', 2);

/* Social login */
define('FB_SOCIAL', 'Facebook');
define('SYSTEM', 'System');

define('AVATAR_URL', 'https://graph.facebook.com/{0}/picture?type=large');

/* cache */
define('KEY_COMMON_ADMIN_CACHE', 'setting_for_admin_site_ntl_');
define('KEY_COMMON_CACHE', 'setting_for_site_ntl_');
define('KEY_MENU_CACHE', 'setting_for_site_ntl_menu_');

define('TIME_DISTANCE', 30);
define('TIME_START_TEXT', "00:00:00");
define('TIME_END_TEXT', "23:00:00");

/*contact type */
define('PHONE', 0);
define('WHATSAPP', 1);
define('VIBER', 2);
define('ZALO', 3);
define('LINK_ZALO_OA_GET_PROFILE','https://openapi.zaloapp.com/oa/v1/getprofile');
define('LINK_ZALO_OA_SEND_TEXT','https://openapi.zaloapp.com/oa/v1/sendmessage/text');


/** type option */
define('OP_SELECT', 1);
define('OP_RADIO', 2);

define('FLOT_MONTH_DISTANCE_SEARCH', 13);

/** API **/
define('TOKEN_EXPIRE', '23:00:00');
define('URL_FACEBOOK_GRAPH', 'https://graph.facebook.com/v3.0/');
define('URL_GET_FACEBOOK_USER_INFO', URL_FACEBOOK_GRAPH . 'me?fields=id,name,email,birthday,gender&access_token=${token}');
define('URL_AVATAR_FACEBOOK', URL_FACEBOOK_GRAPH . '${id}/picture?type=large');

/*Type Slider */
define('SLIDER_IMAGE', 1);
define('SLIDER_VIDEO', 2);

define('SLIDER_VI', 'vi');
define('SLIDER_EN', 'en');

define('API', 1);
define('FILE_ACCESS_KEY', '8415cceef9cb4c8cc6728e35f29d9836');

/** Checkbox */
define('ON', 'on');
define('OFF', 'off');

/** Time sale*/
define('LONGDAY', 1);
define('MORNING', 2);
define('NIGHT', 3);
define('MORNING_SALE_OPEN', '11:00:00');
define('MORNING_SALE_CLOSE', '15:00:00');
define('NIGHT_SALE_OPEN', '18:00:00');
define('NIGHT_SALE_CLOSE', '23:59:59');
