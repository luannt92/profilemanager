<?php
/* prefix  */
define('TABLE_PREFIX', 'pqd_');
define('DOMAIN', 'http://phuquocdelivery.tv');

/* Status */
define('ENABLED', 1);
define('CONFIRM', 1);
define('DISABLED', 0);
define('REFUSE', 0);
define('TRASH', -1);
define('REGISTER_STATUS', 2);
define('PENDING', 2);
define('ACTIVE', 1);
define('DEACTIVE', 0);

define('REMOVE_RECORD', 100);

/* Group */
define('SUPER_ADMIN', 99);
define('ADMIN', 1);
define('MEMBER', 2);
define('SUBSCRIBER', 3);
define('AUTHOR', 4);
define('EDITOR', 5);
define('CONTRIBUTOR', 6);
define('CONTENT', 7);

/* Gender */
define('MALE', 1);
define('FEMALE', 0);

/* Min length */
define('MIN_LENGTH_USERNAME', 6);
define('MIN_LENGTH_PASSWORD', 6);

/* Default language */
define('VI_VN', 1);

define('NO_IMAGE', 'http://via.placeholder.com/280x158');

define('DEFAULT_LIMIT', 20);

/* user type */
define('FREE_TYPE', 1);

/*Email*/
define('MAIL_TEMPLATE_CONTACT', 'TPL0005');
define('MAIL_TEMPLATE_BOOKING_TOUR', 'TPL0006');


/* set timezone */
define('TIME_ZONE', 'Asia/Ho_Chi_Minh');

/* extension file jobs */
define('EXTENSION_FILE_IMAGE', '.png,.jpg,.jpeg,.gif');
define('EXTENSION_FILE_DOCUMENT', '.doc,.docx,.xls,.xlsx,.ppt,.pdf');
define('RULES_MIMETYPE', EXTENSION_FILE_IMAGE . ',' . EXTENSION_FILE_DOCUMENT);
define('NAME_FOLDER_DOC_JOB', 'document' . DS);
define('MAX_FILE_SIZE', 3145728);
define('NAME_FOLDER_AVATAR', 'avatar');

/* menu */
define('MENU', 1);
define('TYPE_CATEGORY', 2);
define('TYPE_TAG', 4);
define('TYPE_PAGE', 3);
define('TYPE_LINK', 5);
define('TYPE_TOUR', 1);

/* menu type */
define('MENU_HEADER', 1);
define('MENU_FOOTER', 2);

/* menu cache */
define('CACHE_MENU', 'menu');
define('CACHE_MENU_TOURS', 'menu-tours');

define('TOUR', 0);
define('CONTACT', 1);

define('MENU_TOP', 1);
define('MENU_NEW', 2);
define('CURRENCY_UNIT', ' VNĐ');
define('CURRENCY_UNIT_1', ' vnđ');

/* Page type */
define('INTRODUCE', 0);

define('DEFAULT_LAST_NEWS', 4);
define('DEFAULT_RELATE_NEWS', 3);

define('LANGUAGE', ['en' => 'Tiếng Anh']);

/* Price */
define('C1_MILLION', 1000000);
define('C3_MILLION', 3000000);
define('C5_MILLION', 5000000);
define('C7_MILLION', 7000000);
define('C10_MILLION', 10000000);
define('C15_MILLION', 15000000);

/* Member */
define('M10', 10);
define('M20', 20);
define('M30', 30);
define('M50', 50);

/* Search*/
define('SEARCH_ALL', 1);

/* Travel category*/
define('FAVORITE', 1);

/* Limit paging*/
define('LIMIT_NEWS', 10);
define('LIMIT_TOURS', 8);
