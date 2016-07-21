<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Site name
define('SITE_NAME','Ecommerce (development)');

// Mail address
define('MAIL_ADDRESS_FROM', 'phamhoaian005@gmail.com');

// Default language
define('LANG','English');

// Sale tax
define('TAX',1.08);

// Google Translate API Key
define('GOOGLE_TRANSLATE_API_KEY', "AIzaSyCVysDldCieAPZDD4dI5i8XoNdqFk4OvNg");

// Turn on cache memory
$config['cache_flag'] = false;

// Cache directory
$config['cache_dir'] = BASEPATH . "cache/web/content/";

// Cache time (in seconds)
$config['cache_lifetime'] = "3600";

// base_url
$config['base_url'] = "";

// Retention period of cookies
$config['cookie_expire'] = 100 * 86400;

// Keyword to be stored in a cookie
$config['cookie_tail'] = "";

$config['ip_member'] = array(
	'127.0.0.1',
);

?>
