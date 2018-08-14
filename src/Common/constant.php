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
define('CENTER', 3);
define('DELIVERY', 4);

/* Gender */
define('MALE', 1);
define('FEMALE', 0);

/* Min length */
define('MIN_LENGTH_USERNAME', 6);
define('MIN_LENGTH_PASSWORD', 6);

/* Default language */
define('VI_VN', 1);

define('NO_IMAGE', 'https://via.placeholder.com/280x158.jpg');
define('NO_IMAGE_DEFAULT', 'https://phuquocdelivery.com/img/thumbs/no-image-default.jpg');

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

/* Payment type */

define('PAYMENT_CASH_ON_DELIVERY', 1);
define('PAYMENT_PAYPAL', 2);
define('PAYMENT_DIRECT_BANK_TRANSFER', 3);

/* Address */
define('DEFAULT_ADDRESS', 1);
define('SELECT_ADDRESS', 2);
define('RECIPIENT_ADDRESS', 1);
define('PAYMENT_ADDRESS', 2);

/* Order*/
define('ORDER_LIMIT', 10);
define('CANCEL', 0);
define('PROCESSING', 1);
define('CONFIRMED', 2);
define('SHIPPED', 3);
define('RECEIVED', 4);
define('CHECKOUT', -1);

define('HOUSE', '1');
define('HOTEL', '2');

/* layout */
define('LAYOUT_GRID', 0);
define('LAYOUT_LIST', 1);

/* Social login */
define('FB_SOCIAL', 'Facebook');
define('SYSTEM', 'System');

define('AVATAR_URL', 'https://graph.facebook.com/{0}/picture?type=large');

/* cache */
define('KEY_COMMON_ADMIN_CACHE', 'setting_for_admin_site_dpd_');
define('KEY_COMMON_CACHE', 'setting_for_site_dpd_');
define('KEY_MENU_CACHE', 'setting_for_site_dpd_menu_');

/* layout service*/
define('LAYOUT_STORE', 0);
define('LAYOUT_SERVICE', 1);

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

/* Min checkout*/
define('MIN_CHECKOUT', 150000);

/* product options */
define('PRODUCT_TYPE_NORMAL', 1);
define('PRODUCT_TYPE_EXTRA', 2);

define('PRODUCT_OPTION_TYPE_SELECTBOX', 1);
define('PRODUCT_OPTION_TYPE_CHECKBOX', 2);

/* type zone */
define('REDZONE', 0);
define('GREENZONE', 1);
define('BLUEZONE', 2);
define('YELLOWZONE', 3);

/** type option */
define('OP_SELECT', 1);
define('OP_RADIO', 2);

/** price zone */
define('PRICE_REDZONE', 25000);
define('PRICE_GREENZONE', 50000);
define('PRICE_BLUEZONE', 75000);
define('PRICE_YELLOWZONE', 100000);

define('PLUS_PRICE', '+');
define('SUB_PRICE', '-');

define('FLOT_MONTH_DISTANCE_SEARCH', 13);

/* file excel*/
define('CREATOR_EXPORT_EXCEL', 'PhuQuocDelivery');
define('TITLE_EXPORT_EXCEL', 'PhuQuocDelivery_Report_{0}');

/** Paypal **/
define('PP_CLIENT_ID', 'AdUnZo3SJSuDMrvxrToCIrgs7PK65DorqxpZ6sh01q2QNjAjms1bFkyjHXMMvjexda_PnerG5TRd5caZ');
define('PP_CLIENT_SECRET', 'EAnfrVFYKjx8tiusUS3vplw1NpGmlctnV4_0I64F8p2N1kCsA6ozAtMGUC_agpNqzyXJ5IPLTa5WLu3L');
define('PP_URL_SUCCESS_URL', DOMAIN . 'payments/success');
define('PP_URL_CANCEL_URL', DOMAIN . 'payments/cancel');
define('PP_URL_EXECUTE_PAYMENT', 'https://api.sandbox.paypal.com/v1/payments/payment/${payment_id}/execute');
define('PP_URL_GET_ACCESS_TOKEN', 'https://api.sandbox.paypal.com/v1/oauth2/token');
define('URL_GET_RATE_USD', 'http://apilayer.net/api/live?access_key=dcab6ec27fadf9760fac697abc3fc7ab&currencies=VND&source=USD&format=1');

define('PP_REDIRECT', '/payments/paypal');
define('URL_STORE_CREDIT_CARD', 'https://api.sandbox.paypal.com/v1/vault/credit-cards');
define('URL_CREDIT_CARD_PAYMENT', 'https://api.sandbox.paypal.com/v1/payments/payment');
define('CASH', 1);
define('PAYPAL', 2);
define('CREDIT_CARD', 3);

/** API **/
define('SHIPPER_KEY', 1);
define('USER_KEY', 2);
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

/** Type time store */
define('DAILY_TIME', 1);
define('CUSTOM_TIME', 2);

/** Type voucher */
define('VOUCHER_PERCENT', 1);
define('VOUCHER_PRICE', 2);

/** Type voucher */
define('VOUCHER_PERCENT_PREFIX', 'PER');
define('VOUCHER_PRICE_PREFIX', 'PRI');

/** Time sale*/
define('LONGDAY', 1);
define('MORNING', 2);
define('NIGHT', 3);
define('MORNING_SALE_OPEN', '11:00:00');
define('MORNING_SALE_CLOSE', '15:00:00');
define('NIGHT_SALE_OPEN', '18:00:00');
define('NIGHT_SALE_CLOSE', '23:59:59');
