<?php

$rootPath = realpath(dirname(__FILE__) . '/../../') . '/';

//define('TestMode', true);

define('SRC_PATH', $rootPath . 'src/');
define('API_PATH', $rootPath . 'src/api/');

require_once(API_PATH . 'lib/Loader.php');

if (!defined('SL_DATABASE')) {
	define('SL_DATABASE', 'studiolive');
}

?>