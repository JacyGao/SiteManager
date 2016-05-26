<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

define('SUBSCRIBE_FLOW_NONE',		            0);
define('SUBSCRIBE_FLOW_PIN',		            1);
define('SUBSCRIBE_FLOW_DOI',		            2);
define('SUBSCRIBE_FLOW_DIRECT_MALAWI',          3);
define('SUBSCRIBE_FLOW_VIA_WAP',		        4);
define('SUBSCRIBE_FLOW_MO',		                5);
define('SUBSCRIBE_FLOW_HIDDEN',		            6);
define('SUBSCRIBE_FLOW_CLICK',                  7);
define('SUBSCRIBE_FLOW_MO_MSG',		            8);
define('SUBSCRIBE_THROUGH_WAP_OPTIN',		    9);

define('LOGIN_FLOW_NO_LOGIN',		             0);
define('LOGIN_FLOW_GOT_PIN',		             1);
define('LOGIN_FLOW_SEND_PIN',		             2);
define('LOGIN_FLOW_SEND_URL',		             3);

define('ORDER_FLOW_ENTER_NUMBER',		         1);
define('ORDER_FLOW_SHOW_KEYWORD',		         2);
define('ORDER_FLOW_DLOAD_FOR_CREDITS',           3);
define('ORDER_FLOW_DLOAD_FOR_FREE',              4);

define('FREE_MESSAGE',		                    0);
define('BILL_MESSAGE',		                    1);

define('SOUTH_AFRICA',  'sa');
define('GHANA',         'gh');
define('KENYA',         'ke');
define('MALAWI',        'ma');
define('CANADA',        'ca');
define('AUSTRALIA',     'au');
define('UK',            'uk');
define('NEW_ZEALAND',   'nz');

define('PIXELTYPE_HTML',		                    0);
define('PIXELTYPE_S2S', 		                    1);

define('ERROR_UNKNOWNKEYWORD', 		                "Unknown Keyword");

define('CURL_POST', 							CURLOPT_POST);
define('CURL_GET', 								CURLOPT_HTTPGET);

/* End of file constants.php */
/* Location: ./application/config/constants.php */