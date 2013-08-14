<?php

$rootPath = realpath(dirname(__FILE__) . '/../../') . '/';

//define('TestMode', true);

define('SRC_PATH', $rootPath . 'src/');
define('API_PATH', $rootPath . 'src/api/');

define('CASPAR_HOST', 'videotest');
define('CASPAR_PORT', '5250');

require_once(API_PATH . 'libraries/palaso/Loader.php');

if (!defined('SL_DATABASE')) {
	define('SL_DATABASE', 'studiolive');
}

?>