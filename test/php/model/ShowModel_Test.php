<?php
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
	
	function testWrite_ReadBackSame() {
		$model = new ShowModel();
		$model->name = "Some User";
		$id = $model->write();

		$this->assertNotNull($id);
		$this->assertIsA($id, 'string');
		$this->assertEqual($id, $model->id);
		
		$otherModel = new ShowModel($id);
		$this->assertEqual($id, $otherModel->id);
		$this->assertEqual('Some User', $otherModel->name);
	}

	function testWriteRemove_ListCorrect() {
		$e = new MongoTestEnvironment();
		$e->clean();

		$list = new ShowListModel();
		$list->read();
		$this->assertEqual(0, $list->count);
		$this->assertEqual(null, $list->entries);
		
		$show = new ShowModel();
		$show->name = "Some Name";
		$id = $show->write();

		$list = new ShowListModel();
		$list->read();
		$this->assertEqual(1, $list->count);
		$this->assertEqual(array(array('name' => 'Some Name', 'id' => $id)), $list->entries);

		ShowModel::remove($id);
		
		$list = new ShowListModel();
		$list->read();
		$this->assertEqual(0, $list->count);
		$this->assertEqual(null, $list->entries);
	}
	
	
}

?>