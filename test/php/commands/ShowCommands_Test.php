<?php
use models\ShowSceneIndexModel;
use commands\ShowCommands;

require_once(dirname(__FILE__) . '/../TestConfig.php');
require_once(SIMPLE_TEST_PATH . 'autorun.php');

require_once(TEST_PATH . 'common/MongoTestEnvironment.php');

class TestShowCommands extends UnitTestCase {

	function __construct() {
		$e = new MongoTestEnvironment();
		$e->clean();
	}
	/*
	function testDeleteShows_NoThrow() {
		$e = new MongoTestEnvironment();
		$showId = $e->createShow('somename');
		ShowCommands::deleteShows(array($showId));
	}
	
	function testDeleteScenes_NoThrow() {
		$e = new MongoTestEnvironment();
		$showId = $e->createShow('somename');
		$sceneId = $e->createScene($showId, 'somescene');
		
		ShowCommands::deleteScenes($showId, array($sceneId));
		
	}
	*/
	function testAddDeleteScenes_UpdatesIndex() {
		$e = new MongoTestEnvironment();
		$showId = $e->createShow('somename');
		
		$object = array('id' => '', 'name' => 'somescene');
		$sceneId = ShowCommands::updateScene($showId, $object);
		
		$sceneIndex = new ShowSceneIndexModel($showId);
		$this->assertTrue(in_array($sceneId, $sceneIndex->scenesIndex->data));
		
 		ShowCommands::deleteScenes($showId, array($sceneId));

 		$sceneIndex = new ShowSceneIndexModel($showId);
 		$this->assertFalse(in_array($sceneId, $sceneIndex->scenesIndex->data));
		
	}
	
}

?>