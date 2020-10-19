<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

// ===============================================================================================================
// CUSTOM CONSTANT
// ===============================================================================================================
//DEVELOPMENT SCHEME
defined('LEGACY')      			OR define('LEGACY', "PREPROD02"); 
defined('MDM')      			OR define('MDM', "PREPROD01"); 
//PRODUCTION SCHEME
// defined('LEGACY')      			OR define('LEGACY', "PRODSAPLEGACY"); 
// defined('MDM')      			OR define('MDM', "PRODSAPMDM"); 

defined('__USERINFO')      		OR define('__USERINFO', "WMS_USERINFO"); 
defined('__MENU')      			OR define('__MENU', "menu_wms"); 

//API
defined('API_URL')      		OR define('API_URL', 'http://10.10.2.57/legacyapi/');
defined('API_ID')      			OR define('API_ID', 'WMS');
defined('API_TOKEN')      		OR define('API_TOKEN', '489ef52948c5420bc0635d930001fab2');
defined('APPS_CODE')      		OR define('APPS_CODE', 'WMS');

//GLOBAL VIEW
defined('APP_NAME')      		OR define('APP_NAME', 'Warehouse Management System');
defined('TITLE_APP')      		OR define('TITLE_APP', 'Warehouse Management System PT Semen Baturaja (Persero) Tbk');
defined('LANGUAGE_APP')      	OR define('LANGUAGE_APP', 'english');

//AUTO NUMBER SECTION
define('FIRST_COUNTER_DB', 100000000);
//STOK AWAL GUDANG
defined('AN_WMS_01_SEQ')      	OR define('AN_WMS_01_SEQ', '1');
defined('AN_WMS_01_DESC')      	OR define('AN_WMS_01_DESC', 'WMS_STOK_AWAL_GUDANG');
//TRANSAKSI GUDANG
defined('AN_WMS_02_SEQ')      	OR define('AN_WMS_02_SEQ', '2');
defined('AN_WMS_02_DESC')      	OR define('AN_WMS_02_DESC', 'WMS_TRANSAKSI_GUDANG');
//ADJUSMENT STOCK
defined('AN_WMS_03_SEQ')      	OR define('AN_WMS_03_SEQ', '3');
defined('AN_WMS_03_DESC')      	OR define('AN_WMS_03_DESC', 'WMS_ADJUSMENT_STOK');
//MAPPING_GUDANG_DISTRIBUTOR
defined('AN_WMS_04_SEQ')      	OR define('AN_WMS_04_SEQ', '4');
defined('AN_WMS_04_DESC')      	OR define('AN_WMS_04_DESC', 'MAPPING_GUDANG_DISTRIBUTOR');
//MASTER_ITEM_CATEGORY
defined('AN_WMS_05_SEQ')      	OR define('AN_WMS_05_SEQ', '5');
defined('AN_WMS_05_DESC')      	OR define('AN_WMS_05_DESC', 'WMS_TRANSAKSI_GUDANG_HISTORY');
//MASTER_IKLAN
defined('AN_WMS_06_SEQ')      	OR define('AN_WMS_06_SEQ', '6');
defined('AN_WMS_06_DESC')      	OR define('AN_WMS_06_DESC', 'WMS_IKLAN');
//ITEM
defined('AN_WMS_07_SEQ')      	OR define('AN_WMS_07_SEQ', '7');
defined('AN_WMS_07_DESC')      	OR define('AN_WMS_07_DESC', 'WMS_ITEM');
//ITEM_DETAIL
defined('AN_WMS_08_SEQ')      	OR define('AN_WMS_08_SEQ', '8');
defined('AN_WMS_08_DESC')      	OR define('AN_WMS_08_DESC', 'WMS_ITEM_DETAIL');
//MASTER_IKLAN_DETAIL
defined('AN_WMS_09_SEQ')      	OR define('AN_WMS_09_SEQ', '9');
defined('AN_WMS_09_DESC')      	OR define('AN_WMS_09_DESC', 'WMS_IKLAN_DETAIL');
//REDEEM_ITEM
defined('AN_WMS_10_SEQ')      	OR define('AN_WMS_10_SEQ', '10');
defined('AN_WMS_10_DESC')      	OR define('AN_WMS_10_DESC', 'WMS_REDEEM_ITEM');
//MASTER_ITEM_CATEGORY
defined('AN_WMS_11_SEQ')      	OR define('AN_WMS_11_SEQ', '11');
defined('AN_WMS_11_DESC')      	OR define('AN_WMS_11_DESC', 'WMS_ITEM_CATEGORY');
//WMS_HISTORY_CANCEL_CHECK_IN
defined('AN_WMS_12_SEQ')      	OR define('AN_WMS_12_SEQ', '12');
defined('AN_WMS_12_DESC')      	OR define('AN_WMS_12_DESC', 'WMS_HISTORY_CANCEL_CHECK_IN');
//WMS_NOTIFIKASI_PENUKARAN
defined('AN_WMS_13_SEQ')      	OR define('AN_WMS_13_SEQ', '13');
defined('AN_WMS_13_DESC')      	OR define('AN_WMS_13_DESC', 'WMS_NOTIFIKASI_PENUKARAN');
//WMS_TRADE_STATUS_HISTORY
defined('AN_WMS_14_SEQ')      	OR define('AN_WMS_14_SEQ', '14');
defined('AN_WMS_14_DESC')      	OR define('AN_WMS_14_DESC', 'WMS_TRADE_STATUS_HISTORY');
//WMS_TRADE
defined('AN_WMS_15_SEQ')      	OR define('AN_WMS_15_SEQ', '15');
defined('AN_WMS_15_DESC')      	OR define('AN_WMS_15_DESC', 'WMS_TRADE');
//WMS_TRADE_DETAIL
defined('AN_WMS_16_SEQ')      	OR define('AN_WMS_16_SEQ', '16');
defined('AN_WMS_16_DESC')      	OR define('AN_WMS_16_DESC', 'WMS_TRADE_DETAIL');
//WMS_HISTORICAL_POINT
defined('AN_WMS_17_SEQ')      	OR define('AN_WMS_17_SEQ', '17');
defined('AN_WMS_17_DESC')      	OR define('AN_WMS_17_DESC', 'WMS_HISTORICAL_POINT');
//WMS_TRADE_HISTORY
// defined('AN_WMS_18_SEQ')      	OR define('AN_WMS_18_SEQ', '18');
// defined('AN_WMS_18_DESC')      	OR define('AN_WMS_18_DESC', 'WMS_TRADE_HISTORY');
//WMS_DETAIL_STATUS_HISTORY
defined('AN_WMS_19_SEQ')      	OR define('AN_WMS_19_SEQ', '19');
defined('AN_WMS_19_DESC')      	OR define('AN_WMS_19_DESC', 'WMS_DETAIL_STATUS_HISTORY');