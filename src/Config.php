<?php
define('VERSION', '0.0.0');
define('BUILD_DATE', '8 October 2013');
define('USE_LIBS', false);

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


define('CASPAR_HOST', 'localhost');
define('CASPAR_PORT', '5250');

if (!defined('SL_DATABASE')) {
	define('SL_DATABASE', 'studiolive');
}

?>
