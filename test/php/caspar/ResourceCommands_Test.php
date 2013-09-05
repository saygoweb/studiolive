<?php
use commands\ResourceCommands;

use models\ShowSceneIndexModel;
use commands\ShowCommands;

require_once(dirname(__FILE__) . '/../TestConfig.php');
require_once(SIMPLE_TEST_PATH . 'autorun.php');

class TestResourceCommands extends UnitTestCase {

	function __construct() {
	}
/*
	function testListImages_ListsImages() {
		$result = ResourceCommands::listImages();
		var_dump($result);
	}
	
	function testListVideo_ListsVideo() {
		$result = ResourceCommands::listVideo();
		var_dump($result);
	}
	
	function testListFlash_ListsFlash() {
		$result = ResourceCommands::listFlash();
		var_dump($result);
	}
	*/
	function testListResources_works() {
		$result = ResourceCommands::listResources();
		var_dump($result);
	}
	
}

?>