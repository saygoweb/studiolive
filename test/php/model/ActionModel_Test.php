<?php

use models\ShowModel;
use models\ActionModel;

require_once(dirname(__FILE__) . '/../TestConfig.php');
require_once(SIMPLE_TEST_PATH . 'autorun.php');

require_once(TEST_PATH . 'common/MongoTestEnvironment.php');

class TestActionModel extends UnitTestCase {

	function __construct() {
		$e = new MongoTestEnvironment();
		$e->clean();
	}
	
	function testWrite_ReadBackSame() {
		$e = new MongoTestEnvironment();
		$showId = $e->createShow('Some Name');
		
		// List
		$show = new ShowModel($showId);
		$actionCount = count($show->actions->data);
		$this->assertTrue($actionCount >= 0);
		
		// Create
		$action = new ActionModel();
		$action->name = 'Some Action';
		$id = ShowModel::writeAction($showId, $action);
		$this->assertNotNull($id);
//		$this->assertEqual('SomeScene', $id);
		
		// Read back
		$otherShow = new ShowModel($showId);
		$otherAction = $otherShow->actions->data[$id];
		$this->assertNotNull($otherAction);
		$this->assertEqual($id, $otherAction->id->id);
		$this->assertEqual('Some Action', $otherAction->name);
		
		// Update
		$otherAction->name = 'Other Action';
		$id = ShowModel::writeAction($showId, $otherAction);
		$this->assertNotNull($id);
		
		// Read back
		$otherShow->read($showId);
		$otherAction = $otherShow->actions->data[$id];
		$this->assertNotNull($otherAction);
		$this->assertEqual($id, $otherAction->id->id);
		$this->assertEqual('Other Action', $otherAction->name);
						
		// List
		$show->read($showId);
		$this->assertEqual($actionCount + 1, count($show->actions->data));
		
		// Delete
		ShowModel::removeAction($showId, $id);
 		
 		// List to check delete
		$show->read($showId);
		$this->assertEqual($actionCount, count($show->actions->data));
	}
	

}

?>