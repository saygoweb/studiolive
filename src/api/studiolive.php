<?php 
require_once(dirname(__FILE__) . '/../Config.php');

if (USE_LIBS) {
	include 'phar://studiolive.phar/studiolive-impl.php';
} else {
	include'studiolive-impl.php';
}

?>