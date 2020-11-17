<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('APP_URL', "https://" . $_SERVER['SERVER_NAME']);
define('SITE_URL', "www.sroomagency.com");
define('SITE_THEME_NAME', "sra");
define('APP_NAME', 'La S Room Agency');
define('SITE_EMAIL', 'contact@secretroomagency.com');
define('RESERVATION_EMAIL', 'reservations@secretroomagency.com');
define('DEV_EMAIL', 'contact@comnstay.fr');
define('SITE_EXP', 'S Room Agency');
define('LOG_MAILIN','contact@sroomagency.com');
define('PASS_MAILIN','s7YQjpVPCKMhbGnw');

/* attention logs perso */
//define('LOG_MAILIN','contact@comnstay.fr');
//define('PASS_MAILIN','k9wpQfc1EbjMV7D2');

define('ADMIN_EMAIL','contact@comnstay.fr');
define('PAGINATION',10);
define('PLAYERS_MIN', 2); // TODO remplacement constant par req DB
define('PLAYERS_MAX', 6);
define('START_HOUR', 10);
define('END_HOUR', 22);
define('GAME_TIME', 2);
define('DELTA', 4);
define('DROP_WE', '18h00');
define('SRA_ADRESS', '40 BIS RUE VOLTAIRE 82000 MONTAUBAN');
define('SRA_TEL', '07 84 96 43 48');

define ("MONETICOPAIEMENT_KEY", "BC6820391E48FBB6EE2F285BEED265DD5D405A94");
define ("MONETICOPAIEMENT_EPTNUMBER", "6732577");
define ("MONETICOPAIEMENT_VERSION", "3.0");
define ("MONETICOPAIEMENT_URLSERVER", "https://p.monetico-services.com/");
define ("MONETICOPAIEMENT_COMPANYCODE", "secretroom");
define ("MONETICOPAIEMENT_URLOK", "https://reservation.sroomagency.com/reservation/orderOk");
define ("MONETICOPAIEMENT_URLKO", "https://reservation.sroomagency.com/reservation/orderDeny");
define ("MONETICOPAIEMENT_URLOK2", "https://reservation.sroomagency.com/voucher/orderOk");
define ("MONETICOPAIEMENT_URLKO2", "https://reservation.sroomagency.com/voucher/orderDeny");
define ("MONETICOPAIEMENT_CTLHMAC","V4.0.sha1.php--[CtlHmac%s%s]-%s");
define ("MONETICOPAIEMENT_CTLHMACSTR", "CtlHmac%s%s");
define ("MONETICOPAIEMENT_PHASE2BACK_RECEIPT","version=2\ncdr=%s");
define ("MONETICOPAIEMENT_PHASE2BACK_MACOK","0");
define ("MONETICOPAIEMENT_PHASE2BACK_MACNOTOK","1\n");
define ("MONETICOPAIEMENT_PHASE2BACK_FIELDS", "%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*");
define ("MONETICOPAIEMENT_PHASE1GO_FIELDS", "%s*%s*%s%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s");
define ("MONETICOPAIEMENT_URLPAYMENT", "paiement.cgi");

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
define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

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

define('SHOW_DEBUG_BACKTRACE', TRUE);

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

define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

