<?php
// Set the CASPAR_HOST and CASPAR_PORT to match your system setup.  Most likely to be localhost.
define('CASPAR_HOST', 'localhost');
define('CASPAR_PORT', '5250');

$webRoot = realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR;

if (!defined('CASPAR_PATH_SNAP')) {
	define('CASPAR_PATH_SNAP', 'C:\CasparCG\CommunityServer\data');
	//define('CASPAR_PATH_SNAP', '/var/www/host/CasparCG/data');
}
if (!defined('SL_PATH_SNAP')) {
	define('SL_PATH_SNAP', $webRoot . 'images/snap');
}

// Set to false to remove the preview feature entirely.
define('HAS_PREVIEW', true);

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

define('VERSION', '0.0.0 DEV');
define('BUILD_DATE', '8 October 2013');

?>
