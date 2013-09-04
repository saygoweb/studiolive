<?php
use commands\MediaCommands;

use models\ShowSceneIndexModel;
use commands\ShowCommands;

require_once(dirname(__FILE__) . '/../TestConfig.php');
require_once(SIMPLE_TEST_PATH . 'autorun.php');

class TestMediaCommands extends UnitTestCase {

	function __construct() {
	}

	function testListImages_ListsImages() {
		$result = MediaCommands::listImages();
		var_dump($result);
	}
	
}

?>