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
		$this->assertNotNull($result['id']);
		$this->assertEqual('SomeShow', $result['name']);
		
		// Update
		$result['name'] = 'OtherShow';
		$id = $api->show_update($result);
		$this->assertNotNull($id);
		$this->assertEqual($result['id'], $id);
		
		// Read back
		$result = $api->show_read($id);
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
	
/*
	function testShowTypeahead_Ok() {
		$e = new ShowAPITestEnvironment();
		$e->addShow('Some Show');
		
		$api = new jsonRPCClient("http://scriptureforge.local/api/sf", false);
		$result = $api->show_typeahead('ome');
		
		$this->assertTrue($result['count'] > 0);
		
		$e->dispose();
	}
	*/
	
}

?>