<?php
use models\ShowListModel;

require_once(dirname(__FILE__) . '/../TestConfig.php');
require_once(SIMPLE_TEST_PATH . 'autorun.php');

require_once(TEST_PATH . 'common/MongoTestEnvironment.php');

use models\ShowModel;

class TestShowModel extends UnitTestCase {

	private $_someShowId;
	
	function __construct()
	{
		$e = new MongoTestEnvironment();
		$e->clean();
	}
	
	function testWrite_ReadBackSame()
	{
		$model = new ShowModel();
		$model->name = "Some User";
		$id = $model->write();

		$this->assertNotNull($id);
		$this->assertIsA($id, 'string');
		
		$otherModel = new ShowModel($id);
		$this->assertEqual($id, $otherModel->id);
		$this->assertEqual('Some User', $otherModel->name);
		
		$this->_someShowId = $id;
	}

	function testShowList_HasCountAndEntries()
	{
		$model = new ShowListModel();
		$model->read();
		
		$this->assertEqual(1, $model->count);
		$this->assertNotNull($model->entries);
	}
	
	function testRemove_Removes() {
		$result = ShowModel::remove($this->_someShowId);
		$this->assertEqual(1, $result);
	}
	
}

?>