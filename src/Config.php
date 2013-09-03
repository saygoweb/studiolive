<?php
// Set the CASPAR_HOST and CASPAR_PORT to match your system setup.  Most likely to be localhost.
define('CASPAR_HOST', 'localhost');
define('CASPAR_PORT', '5250');

define('USE_BOOT', true);

// -------------------------------------------------------------------
// You shouldn't need to change anything below this line.
// -------------------------------------------------------------------
if (!defined('SL_DATABASE')) {
	define('SL_DATABASE', 'studiolive');
}

// -------------------------------------------------------------------
// Changing anything below this line may well break things quite badly.
// -------------------------------------------------------------------
define('USE_LIBS', true);
if (USE_LIBS) {
	$pharFile = realpath(dirname(__FILE__) . '/api/studiolive.phar');
	$rootPath = 'phar://' . $pharFile . '/';
	
	define('API_PATH', $rootPath);
	
	require_once(API_PATH . 'libraries/palaso/Loader.php');

} else {
	$rootPath = realpath(dirname(__FILE__) . '/../') . '/';
	
	define('SRC_PATH', $rootPath . 'src/');
	define('API_PATH', $rootPath . 'src/api/');

	require_once(API_PATH . 'libraries/palaso/Loader.php');
}

define('VERSION', '0.0.0');
define('BUILD_DATE', '8 October 2013');

?>
