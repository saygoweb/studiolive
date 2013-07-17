<?php
use models\ShowSceneIndexModel;

use models\ShowListModel;
use models\ShowModel;
use models\ShowScenesIndexModel;

require_once(dirname(__FILE__) . '/../TestConfig.php');
require_once(SIMPLE_TEST_PATH . 'autorun.php');

require_once(TEST_PATH . 'common/MongoTestEnvironment.php');

class TestShowSceneIndexModel extends UnitTestCase {

	function __construct()
	{
		$e = new MongoTestEnvironment();
		$e->clean();
	}
	
	function testWrite_SomeShow_ReadBackOnlyIndexChanged()
	{
		$show = new ShowModel();
		$show->name = "Some User";
		$show->scenes = array('index1' => '', 'index2' => '');
		$show->scenesIndex[] = 'index1';
		$show->scenesIndex[] = 'index2';
		$id = $show->write();
		
		// Update index
		$model = new ShowSceneIndexModel($id);
		$this->assertEqual($show->scenesIndex, $model->scenesIndex);
		$model->scenesIndex[0] = 'index2';
		$model->scenesIndex[1] = 'index1';
		$model->write();
		
		// Read back index
		$otherModel = new ShowSceneIndexModel($id);
		$this->assertEqual($model->scenesIndex, $otherModel->scenesIndex);
		
		// Read back model
		$otherShow = new ShowModel($id);
		$this->assertEqual($otherModel->scenesIndex, $otherShow->scenesIndex);
		$this->assertEqual($show->name, $otherShow->name);
	}
	
}

?>