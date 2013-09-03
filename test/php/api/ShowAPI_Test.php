<?php
require_once(dirname(__FILE__) . '/../TestConfig.php');
require_once(SIMPLE_TEST_PATH . 'autorun.php');

require_once(TEST_LIB_PATH. 'jsonRPCClient.php');

class ShowAPITestEnvironment
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
	function addShow($name = 'Some Show', $username = 'someuser', $email = 'someuser@example.com') {
		$param = array(
			'id' => '',
			'name' => $name,
			'username' => $username,
			'email' => $email
		);
		$id = $this->_api->show_update($param);
		$this->_idAdded[] = $id;
	}
	
	function dispose() {
		$this->_api->show_delete($this->_idAdded);
	}
}

class TestShowAPI extends UnitTestCase {

	function __construct() {
	}
	
	function testShowCRUD_CRUDOK() {
		$api = new jsonRPCClient("http://studiolive.local/api/studiolive.php", false);
		
		// List
		$result = $api->show_list();
		$showCount = $result['count'];
		$this->assertTrue($showCount >= 0);
		
		// Create
		$param = array(
			'id' => '',
			'name' =>'SomeShow'
		);
		$id = $api->show_update($param);
		$this->assertNotNull($id);
		$this->assertEqual(24, strlen($id));
		
		// Read
		$result = $api->show_read($id);
		$result = $result['show'];
		$this->assertNotNull($result['id']);
		$this->assertEqual('SomeShow', $result['name']);
		
		// Update
		$result['name'] = 'OtherShow';
		$id = $api->show_update($result);
		$this->assertNotNull($id);
		$this->assertEqual($result['id'], $id);
		
		// Read back
		$result = $api->show_read($id);
		$result = $result['show'];
		$this->assertNotNull($result['id']);
		$this->assertEqual('OtherShow', $result['name']);
		
		// List
		$result = $api->show_list();
		$this->assertEqual($showCount + 1, $result['count']);
		
		// Delete
 		$result = $api->show_delete(array($id));
 		$this->assertEqual(1, $result);
 		
 		// List to check delete
		$result = $api->show_list();
		$this->assertEqual($showCount, $result['count']);
	}
	
	function testActionsCRUD_Ok() {
		$api = new jsonRPCClient("http://studiolive.local/api/studiolive.php", false);
		
		// Create Show
		$param = array(
				'id' => '',
				'name' =>'SomeShow'
		);
		$showId = $api->show_update($param);
		$this->assertNotNull($showId);
		$this->assertEqual(24, strlen($showId));
		
		// List (via show)
		$result = $api->show_read($showId);
		$result = $result['show'];
		$this->assertNotNull($result['id']);
		$this->assertEqual(0, count($result['actions']));

		// Create
		$param = array(
				'id' => '',
				'name' => 'Some Action'
		);
		$actionId = $api->show_updateAction($showId, $param);
		$this->assertNotNull($actionId);
		$this->assertEqual(24, strlen($actionId));
		
		// Read back (via show)
		$result = $api->show_read($showId);
		$result = $result['show'];
		$result = $result['actions'][$actionId];
		$this->assertEqual('Some Action', $result['name']);
		
		// Update
		$result['name'] = 'Other Action';
		$otherActionId = $api->show_updateAction($showId, $result);
		$this->assertEqual($actionId, $otherActionId);
		
		// Read back (via show)
		$result = $api->show_read($showId);
		$result = $result['show'];
		$this->assertEqual('Other Action', $result['actions'][$actionId]['name']);
		
		// List (via show above)
		$this->assertEqual(1, count($result['actions']));
		
		// Delete
		$result = $api->show_removeAction($showId, $actionId);
			
		// List to check delete
		$result = $api->show_read($showId);
		$result = $result['show'];
		$this->assertEqual(0, count($result['actions']));
	}
	
}

?>