<?php
require_once(dirname(__FILE__) . '/../TestConfig.php');
require_once(SIMPLE_TEST_PATH . 'autorun.php');

require_once(TEST_LIB_PATH. 'jsonRPCClient.php');

class SceneAPITestEnvironment
{
	/**
	 * @var jsonRPCClient
	 */
	private $_api;
	
	/**
	 * @var array
	 */
	private $_idAdded = array();
	
	function __construct() {
		$this->_api = new jsonRPCClient("http://studiolive.local/api/studiolive.php", false);
	}
	
	/**
	 * @param string $name
	 * @param string $username
	 * @param string $email
	 */
	function addShow($name = 'Some Show') {
		$param = array(
			'id' => '',
			'name' => $name
		);
		$id = $this->_api->show_update($param);
		$this->_idAdded[] = $id;
		return $id;
	}
	
	function dispose() {
		$this->_api->show_delete($this->_idAdded);
	}
}

class TestSceneAPI extends UnitTestCase {

	function __construct() {
	}
	
	function testSceneCRUD_CRUDOK() {
		$api = new jsonRPCClient("http://studiolive.local/api/studiolive.php", false);
		$e = new SceneAPITestEnvironment();
		$showId = $e->addShow();
		
		// List
		$result = $api->show_read($showId);
		var_dump($result);
		$sceneCount = count($result['scenes']);
		$this->assertTrue($sceneCount >= 0);
		
		// Create
		$param = array(
			'id' => '',
			'name' =>'Some Scene'
		);
		$id = $api->scene_update($showId, $param);
		$this->assertNotNull($id);
		$this->assertEqual('SomeScene', $id);
		
		// Read
		$result = $api->scene_read($showId, $id);
		$this->assertNotNull($result);
		$this->assertEqual('SomeScene', $result['id']);
		$this->assertEqual('Some Scene', $result['name']);
		
		// Update
		$result['name'] = 'Other Scene';
		$id = $api->scene_update($showId, $result);
		$this->assertNotNull($id);
		
		// Read back
		$result = $api->scene_read($showId, $id);
		$this->assertNotNull($result);
		$this->assertEqual('Other Scene', $result['name']);
				
		// List
		$result = $api->show_read($showId);
		$this->assertEqual($sceneCount + 1, count($result['scenes']));
		
		// Delete
 		$result = $api->scene_delete($showId, array($id));
 		$this->assertEqual(1, $result);
 		
 		// List to check delete
		$result = $api->show_read($showId);
 		$this->assertEqual($sceneCount, count($result['scenes']));
	}
	
/*
	function testSceneTypeahead_Ok() {
		$e = new SceneAPITestEnvironment();
		$e->addScene('Some Scene');
		
		$api = new jsonRPCClient("http://scriptureforge.local/api/sf", false);
		$result = $api->scene_typeahead('ome');
		
		$this->assertTrue($result['count'] > 0);
		
		$e->dispose();
	}
	*/
	
}

?>