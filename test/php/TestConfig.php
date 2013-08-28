<?php

$rootPath = realpath(dirname(__FILE__) . '/../../') . '/';

//define('TestMode', true);

define('TEST_PATH', $rootPath . 'test/php/');
define('TEST_LIB_PATH', $rootPath . 'test/lib/');
define('SIMPLE_TEST_PATH', $rootPath . 'test/lib/simpletest/');

define('SL_DATABASE', 'studiolive_test');

require_once($rootPath . 'src/Config.php');


?>