<?php
use models\ActionModel;

use models\ShowListModel;
use models\ShowModel;

require_once(dirname(__FILE__) . '/../TestConfig.php');
require_once(SIMPLE_TEST_PATH . 'autorun.php');

require_once(TEST_PATH . 'common/MongoTestEnvironment.php');

class TestShowModel extends UnitTestCase {

	function __construct() {
		$e = new MongoTestEnvironment();
		$e->clean();
	}
	
	function testCRUD_Ok() {
		// List
		$list = new ShowListModel();
		$list->read();
		$this->assertEqual(0, $list->count);
		
		// Create
		$show = new ShowModel();
		$show->name = "Some Show";
		$id = $show->write();
		$this->assertNotNull($id);
		$this->assertIsA($id, 'string');
		$this->assertEqual($id, $show->id->asString());
		
		// Read back
		$otherShow = new ShowModel($id);
		$this->assertEqual($id, $otherShow->id->asString());
		$this->assertEqual('Some Show', $otherShow->name);
		
		// Update
		$otherShow->name = 'Other Show';
		$otherShow->write();

		// Read back
		$otherShow = new ShowModel($id);
		$this->assertEqual('Other Show', $otherShow->name);
		
		// List
		$list->read();
		$this->assertEqual(1, $list->count);

		// Delete
		ShowModel::remove($id);
		
		// List
		$list->read();
		$this->assertEqual(0, $list->count);	
	}
	
}

?>