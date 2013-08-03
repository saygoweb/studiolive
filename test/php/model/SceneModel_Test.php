<?php

use models\ShowModel;
use models\SceneModel;

require_once(dirname(__FILE__) . '/../TestConfig.php');
require_once(SIMPLE_TEST_PATH . 'autorun.php');

require_once(TEST_PATH . 'common/MongoTestEnvironment.php');

class TestSceneModel extends UnitTestCase {

	function __construct() {
		$e = new MongoTestEnvironment();
		$e->clean();
	}
	
	function testWrite_ReadBackSame() {
		$e = new MongoTestEnvironment();
		$showId = $e->createShow('Some Name');
		
		// List
		$show = new ShowModel($showId);
		$sceneCount = count($show->scenes->data);
		$this->assertTrue($sceneCount >= 0);
		
		// Create
		$scene = new SceneModel();
		$scene->name = 'Some Scene';
		$id = ShowModel::writeScene($showId, $scene);
		$this->assertNotNull($id);
		$this->assertEqual('SomeScene', $id);
		
		// Read back
		$otherScene = ShowModel::readScene($showId, $id);
		$this->assertNotNull($otherScene);
		$this->assertEqual('SomeScene', $otherScene->id->id);
		$this->assertEqual('Some Scene', $otherScene->name);
		
		// Update
		$otherScene->name = 'Other Scene';
		$id = ShowModel::writeScene($showId, $otherScene);
		$this->assertNotNull($id);
		
		// Read back
		$otherScene = ShowModel::readScene($showId, $id);
		$this->assertNotNull($otherScene);
		$this->assertEqual('SomeScene', $otherScene->id->id);
		$this->assertEqual('Other Scene', $otherScene->name);
						
		// List
		$show->read($showId);
		$this->assertEqual($sceneCount + 1, count($show->scenes->data));
		
		// Delete
		ShowModel::removeScene($showId, $id);
//  		$this->assertEqual(1, $result);
 		
 		// List to check delete
		$show->read($showId);
		$this->assertEqual($sceneCount, count($show->scenes->data));
	}
	

}

?>