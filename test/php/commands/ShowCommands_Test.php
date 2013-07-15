<?php
use commands\ShowCommands;

require_once(dirname(__FILE__) . '/../TestConfig.php');
require_once(SIMPLE_TEST_PATH . 'autorun.php');

require_once(TEST_PATH . 'common/MongoTestEnvironment.php');

class TestUserCommands extends UnitTestCase {

	function __construct()
	{
	}
	
	function testDeleteUsers_NoThrow() {
		$e = new MongoTestEnvironment();
		$e->clean();
		
		$userId = $e->createUser('somename', 'Some Name', 'somename@example.com');
		
		UserCommands::deleteUsers(array($userId));
	}
	
}

?>