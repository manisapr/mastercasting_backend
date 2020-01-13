<?php
//Change these values below.


// beta creds

// define('FEDEX_ACCOUNT_NUMBER', '510087780');
// define('FEDEX_METER_NUMBER', '100423414');
// define('FEDEX_KEY', 'tU9f2POawvmbDpOf');
// define('FEDEX_PASSWORD', 'Om8u8d1aVbJQ2kJNZsTIY0I6e ');


// in production creds

define('FEDEX_ACCOUNT_NUMBER', '590803146');
define('FEDEX_METER_NUMBER', '250518948');
define('FEDEX_KEY', 'bxT8tr2Bl1mz5mxe');
define('FEDEX_PASSWORD', 'ErdW9wry2FXHDaElDZd9EvFmg');

if (!defined('FEDEX_ACCOUNT_NUMBER') || !defined('FEDEX_METER_NUMBER') || !defined('FEDEX_KEY') || !defined('FEDEX_PASSWORD')) {
    die("The constants 'FEDEX_ACCOUNT_NUMBER', 'FEDEX_METER_NUMBER', 'FEDEX_KEY', and 'FEDEX_PASSWORD' need to be defined in: " . realpath(__FILE__));
}
