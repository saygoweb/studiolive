<?php
use commands\MediaCommands;

use models\ShowSceneIndexModel;
use commands\ShowCommands;

require_once(dirname(__FILE__) . '/../TestConfig.php');
require_once(SIMPLE_TEST_PATH . 'autorun.php');

class TestMediaCommands extends UnitTestCase {

	function __construct() {
	}
/*
	function testListImages_ListsImages() {
		$result = MediaCommands::listImages();
		var_dump($result);
	}
	
	function testListVideo_ListsVideo() {
		$result = MediaCommands::listVideo();
		var_dump($result);
	}
	
	function testListFlash_ListsFlash() {
		$result = MediaCommands::listFlash();
		var_dump($result);
	}
	*/
	function testListResources_works() {
		$result = MediaCommands::listResources();
		var_dump($result);
	}
	
}

?>