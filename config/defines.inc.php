<?php
/*
* 2007-2011 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2011 PrestaShop SA
*  @version  Release: $Revision: 7046 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

define('_PS_MODE_DEV_', false);

$currentDir = dirname(__FILE__);

if (!defined('PHP_VERSION_ID'))
{
    $version = explode('.', PHP_VERSION);
    define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
}

/* Theme URLs */
define('_THEMES_DIR_',     __PS_BASE_URI__.'themes/');
define('_THEME_DIR_',      _THEMES_DIR_._THEME_NAME_.'/');
define('_THEME_IMG_DIR_',  _THEME_DIR_.'img/');
define('_THEME_CSS_DIR_',  _THEME_DIR_.'css/');
define('_THEME_JS_DIR_',   _THEME_DIR_.'js/');

/* Image URLs */
define('_PS_IMG_',         			__PS_BASE_URI__.'img/');
define('_PS_ADMIN_IMG_',   			_PS_IMG_.'admin/');
define('_PS_TMP_IMG_',   			_PS_IMG_.'tmp/');
define('_THEME_CAT_DIR_',  			_PS_IMG_.'c/');
define('_THEME_PROD_DIR_', 			_PS_IMG_.'p/');
define('_THEME_MANU_DIR_', 			_PS_IMG_.'m/');
define('_THEME_SCENE_DIR_', 		_PS_IMG_.'scenes/');
define('_THEME_SCENE_THUMB_DIR_', 	_PS_IMG_.'scenes/thumbs');
define('_THEME_SUP_DIR_',  			_PS_IMG_.'su/');
define('_THEME_SHIP_DIR_',			_PS_IMG_.'s/');
define('_THEME_STORE_DIR_',			_PS_IMG_.'st/');
define('_THEME_LANG_DIR_',			_PS_IMG_.'l/');
define('_THEME_COL_DIR_', 			_PS_IMG_.'co/');
define('_SUPP_DIR_',      			_PS_IMG_.'su/');
define('_PS_PROD_IMG_', 			'img/p/');

/* Other URLs */
define('_PS_JS_DIR_',               __PS_BASE_URI__.'js/');
define('_PS_CSS_DIR_',              __PS_BASE_URI__.'css/');
define('_THEME_PROD_PIC_DIR_', 	__PS_BASE_URI__.'upload/');
define('_MAIL_DIR_',        	__PS_BASE_URI__.'mails/');
define('_MODULE_DIR_',        	__PS_BASE_URI__.'modules/');

/* Directories */
define('_PS_ROOT_DIR_',             realpath($currentDir.'/..'));
define('_PS_CLASS_DIR_',            _PS_ROOT_DIR_.'/classes/');
define('_PS_CONTROLLER_DIR_',       _PS_ROOT_DIR_.'/controllers/');
define('_PS_TRANSLATIONS_DIR_',     _PS_ROOT_DIR_.'/translations/');
define('_PS_DOWNLOAD_DIR_',         _PS_ROOT_DIR_.'/download/');
define('_PS_MAIL_DIR_',             _PS_ROOT_DIR_.'/mails/');
define('_PS_ALL_THEMES_DIR_',       _PS_ROOT_DIR_.'/themes/');
define('_PS_THEME_DIR_',            _PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/');
define('_PS_IMG_DIR_',              _PS_ROOT_DIR_.'/img/');
if (!defined('_PS_MODULE_DIR_'))
	define('_PS_MODULE_DIR_',              _PS_ROOT_DIR_.'/modules/');
define('_PS_CAT_IMG_DIR_',          _PS_IMG_DIR_.'c/');
define('_PS_STORE_IMG_DIR_',		_PS_IMG_DIR_.'st/');
define('_PS_PROD_IMG_DIR_',         _PS_IMG_DIR_.'p/');
define('_PS_SCENE_IMG_DIR_',        _PS_IMG_DIR_.'scenes/');
define('_PS_SCENE_THUMB_IMG_DIR_',  _PS_IMG_DIR_.'scenes/thumbs/');
define('_PS_MANU_IMG_DIR_',         _PS_IMG_DIR_.'m/');
define('_PS_SHIP_IMG_DIR_',         _PS_IMG_DIR_.'s/');
define('_PS_SUPP_IMG_DIR_',         _PS_IMG_DIR_.'su/');
define('_PS_COL_IMG_DIR_',			_PS_IMG_DIR_.'co/');
define('_PS_TMP_IMG_DIR_',          _PS_IMG_DIR_.'tmp/');
define('_PS_UPLOAD_DIR_',			_PS_ROOT_DIR_.'/upload/');
define('_PS_TOOL_DIR_',             _PS_ROOT_DIR_.'/tools/');
define('_PS_GEOIP_DIR_',            _PS_TOOL_DIR_.'geoip/');
define('_PS_SWIFT_DIR_',            _PS_TOOL_DIR_.'swift/');
define('_PS_FPDF_PATH_',            _PS_TOOL_DIR_.'fpdf/');
define('_PS_TAASC_PATH_',            _PS_TOOL_DIR_.'taasc/');
define('_PS_PEAR_XML_PARSER_PATH_', _PS_TOOL_DIR_.'pear_xml_parser/');

/* settings php */
define('_PS_TRANS_PATTERN_',            '(.*[^\\\\])');
define('_PS_MIN_TIME_GENERATE_PASSWD_', '360');
if (!defined('_PS_MAGIC_QUOTES_GPC_'))
	define('_PS_MAGIC_QUOTES_GPC_',         get_magic_quotes_gpc());
if (!defined('_PS_MYSQL_REAL_ESCAPE_STRING_'))
	define('_PS_MYSQL_REAL_ESCAPE_STRING_', function_exists('mysql_real_escape_string'));

define('_CAN_LOAD_FILES_', 1);

/* Order states */
define('_PS_OS_CHEQUE_',      1);
define('_PS_OS_PAYMENT_',     2);
define('_PS_OS_PREPARATION_', 3);
define('_PS_OS_SHIPPING_',    4);
define('_PS_OS_DELIVERED_',   5);
define('_PS_OS_CANCELED_',    6);
define('_PS_OS_REFUND_',      7);
define('_PS_OS_ERROR_',       8);
define('_PS_OS_OUTOFSTOCK_',  9);
define('_PS_OS_BANKWIRE_',    10);
define('_PS_OS_PAYPAL_',      11);
define('_PS_OS_WS_PAYEMENT_', 12);
define('_PS_OS_OP_PAYEMENT_ACCEPTED', 13);
define('_PS_OS_OP_PAYEMENT_FAILED', 14);
define('_PS_OS_COD_PENDING_CONFIRMATION', 15);
define('_PS_OS_READY_TO_SHIP', 16);
define('_PS_OS_LOST_DAMAGED_IN_TRANSIT', 17);
//define('_PS_OS_WS_PAYEMENT_', 18);
define('_PS_OS_WIP_DELAYED', 19);
define('_PS_OS_EDITED', 23);

/*Payment status*/
define('_PS_PS_NOT_PAID_', 1);
define('_PS_PS_PAYMENT_WITH_CARRIER_', 2);
define('_PS_PS_PAID_', 3);

/* Tax behavior */
define('PS_PRODUCT_TAX', 0);
define('PS_STATE_TAX', 1);
define('PS_BOTH_TAX', 2);

define('_PS_PRICE_DISPLAY_PRECISION_', 2);
define('PS_TAX_EXC', 1);
define('PS_TAX_INC', 0);

define('PS_ORDER_PROCESS_STANDARD', 0);
define('PS_ORDER_PROCESS_OPC', 1);

define('PS_ROUND_UP', 0);
define('PS_ROUND_DOWN', 1);
define('PS_ROUND_HALF', 2);

/* Carrier::getCarriers() filter */
define('PS_CARRIERS_ONLY', 1);
define('CARRIERS_MODULE', 2);
define('CARRIERS_MODULE_NEED_RANGE', 3);
define('PS_CARRIERS_AND_CARRIER_MODULES_NEED_RANGE', 4);
define('ALL_CARRIERS', 5);

/* SQL Replication management */
define('_PS_USE_SQL_SLAVE_', 0);

/* PS Technical configuration */
define('_PS_ADMIN_PROFILE_', 1);

/* Stock Movement */
define('_STOCK_MOVEMENT_ORDER_REASON_', 3);
define('_STOCK_MOVEMENT_MISSING_REASON_', 4);

define('_PS_DEFAULT_CUSTOMER_GROUP_', 1);

define('_PS_CACHEFS_DIRECTORY_', dirname(__FILE__).'/../cache/cachefs/');

/* Geolocation */
define('_PS_GEOLOCATION_NO_CATALOG_', 0);
define('_PS_GEOLOCATION_NO_ORDER_', 1);

/* Media versions */
define('CSS_ALL_VERSION', 123);
define('CSS_SCREEN_VERSION', 123);
define('JS_VERSION', 115);
define('IMG_VERSION', 1);

/* Carriers*/
define('UPS', 13);
define('ARAMEX', 10);
define('FEDEX', 12);
define('BLUEDART', 14);

if (!defined('_PS_CACHE_ENABLED_'))
    define('_PS_CACHE_ENABLED_', 0);

/* facebook defines */


// define('FB_API_KEY', '285166361588635');
// define('FB_SECRET', '2b06b71c9041e61b6c15bd379b0f2f0f');
// FB_DATA_FILE', '/var/www/facebookdata.txt');


define('FB_API_KEY', '122124854665');
define('FB_SECRET', 'cd71af1858102fe0a2b731d232ed6dbb');
define('FB_DATA_FILE', '/Applications/XAMPP/htdocs/indusdiva2/facebookdata.txt');


define('PREPAID_DISCOUNT', 0);
define('COD_CHARGE', 70.0);

/* Rule Events*/
define('EVENT_ORDER_DELIVERED', 1);
define('EVENT_FACEBOOK_LIKE', 2);
define('EVENT_GOOGLE_LIKE', 3);
define('EVENT_FACEBOOK_UNLIKE', 4);
define('EVENT_GOOGLE_UNLIKE', 5);
define('EVENT_REVIEW_APPROVED', 6);
define('EVENT_REGISTRATION', 7);
define('EVENT_POINTS_REDEEMED', 8);
define('EVENT_ORDER_CANCELLED', 9);
define('ONLINE_ORDER', 10);
define('EVENT_ORDER_FEEDBACK', 11);
define('EVENT_WRITE_TESTIMONIAL',12 );
define('EVENT_ORDER_FACEBOOK_SHARE',13);
define('EVENT_WISHLIST_PRODUCT_FACEBOOK_SHARE',14);
define('EVENT_FACEBOOK_PAGE_LIKE',15);
define('EVENT_FACEBOOK_PAGE_UNLIKE',16);

define('POINTS_TO_CASH', (float)0.2);
define('FREE_GIFT_ID', 9929);

// define('SOLR_SERVER', '10.134.17.222');
define('SOLR_SERVER', 'localhost');

/* SQS queue */
//define('RULES_QUEUE', 'https://ap-southeast-1.queue.amazonaws.com/546655006003/vbq_rules_prod');
//define('INVITE_QUEUE', 'https://ap-southeast-1.queue.amazonaws.com/546655006003/vbq_invite_prod');
//define('RULES_QUEUE', 'https://ap-southeast-1.queue.amazonaws.com/546655006003/testinvite');
//define('INVITE_QUEUE', 'https://ap-southeast-1.queue.amazonaws.com/546655006003/testq');

define('IMAGE_UPLOAD_PATH', '/home/s3-dev-images-bckup-folder/product-imgs/');
define('RULES_QUEUE', 'https://sqs.ap-southeast-1.amazonaws.com/546655006003/idq_rules_prod');
define('INVITE_QUEUE', 'https://sqs.ap-southeast-1.amazonaws.com/546655006003/idq_invite_prod');
define('STOCK_SYNC_QUEUE', 'https://sqs.ap-southeast-1.amazonaws.com/546655006003/stock_sync_prod');


define('ID_FALL_PIKO_WORK_FEE',2);
define('ID_PRESTITCHED_SAREE_FEE', 6);
define('ID_PRESTITCHED_BLOUSE_FEE', 16);
define('ID_PRESTITCHED_INSKIRT_FEE', 9);
define('ID_PRESTITCHED_SKD_FEE', 9);
define('ID_PRESTITCHED_KAMEEZ_FEE', 5);
define('ID_PRESTITCHED_ANARKALI_FEE', 14);
define('ID_PRESTITCHED_LC_FEE', 25);
define('ID_LONGCHOLI_FEE', 9);
define('ID_CHOLILONGSLEEVES_FEE', 9);
define('ID_CORSETCHOLI_FEE', 36);

define('CAT_SAREE', 2);
define('CAT_SKD', 3);
define('CAT_ANARKALI', 90);
define('CAT_LEHENGA', 5);
define('CAT_BOTTOMS', 137);
define('CAT_CHOLIS', 141);
define('IMAGE_SIZE_LARGE', 1);
define('IMAGE_SIZE_SMALL', 2);
define('CAT_CURATED', 449);
define('CAT_GIFTCARD', 453);
define('CAT_JEWELRY', 454);
define('CAT_KIDS', 476);
define('CAT_ABAYA', 512);
define('CAT_MEN', 513);
define('CAT_PAKISTANI_SKD', 143);
define('CAT_BOLLYWOOD_SAREE',551);
define('CAT_BOLLYWOOD_SKD',552);
define('CAT_BOLLYWOOD_LEHENGA',553);
define('CAT_HANDBAG',1175);
define('CAT_KURTI',4);
define('CAT_NEW_KURTI',1202);
define('CAT_ACCESSORIES',1190);

define('IND_ADDRESS_ID', 3);
define('DEFAULT_HTTP_HOST', 'indusdiva.local');
define('IND_ZONE_ID', 9);
define('SHIPPING_PER_ITEM_1', 10);
define('SHIPPING_PER_ITEM_2', 9);
define('SHIPPING_PER_ITEM_3', 8);
define('SHIPPING_PER_ITEM_MORE', 7);

/*Product Stats*/
define('PSTAT_FB_LIKE',1 );
define('PSTAT_FB_UNLIKE',2 );
define('PSTAT_G_PLUS',3 );
define('PSTAT_G_UNPLUS',4 );
define('PSTAT_FB_SHARE',5 );
define('PSTAT_PIN',6 );
define('PSTAT_ADD_WL',7 );
define('PSTAT_ADD_BAG',8 );
define('PSTAT_VIEWS',9 );
define('PSTAT_SALES',10 );
define('PSTAT_DEL_WL',11 );

define('MIN_CRITERIA_NOT_MET', 4);
define('INSUFFICIENT_VALID_ORDERS', 3);
define('CAN_REDEEM_COINS', 2);
define('CANNOT_REDEEM_COINS', 1);
