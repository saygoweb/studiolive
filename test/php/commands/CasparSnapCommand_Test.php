<?php
use models\mapper\caspar\CasparConnection;

use commands\CasparSnapCommand;

require_once(dirname(__FILE__) . '/../TestConfig.php');
require_once(SIMPLE_TEST_PATH . 'autorun.php');

class CasparSnapTestConnection {
	
	public $dateTime;
	
	public $response;
	
	public function __construct() {
		$this->response = '202 PRINT OK';
	}
	
	public function sendString($casparCommand, $endMarker = CasparConnection::SINGLE_LINE_RESPONSE) {
		if (strstr($casparCommand, 'PRINT') !== false) {
			$this->dateTime = new \DateTime();
			$filePath = sprintf("%s%s%s.png", CASPAR_PATH_SNAP, DIRECTORY_SEPARATOR, $this->dateTime->format('Ymd\THis'));
			file_put_contents($filePath, 'Fake data for Studio Live tests');
			return $this->response;
		}
	}
	
}

class TestCasparSnapCommand extends UnitTestCase {

	function __construct() {
		$casparTestConnection = new CasparSnapTestConnection();
		//CasparConnection::connect(CASPAR_HOST, CASPAR_PORT, $casparTestConnection);
	}
	
	function testSnapCommand() {
		$command = new CasparSnapCommand();
		$result = $command->snap(1);
		var_dump($result);
		
		$this->assertTrue(false);
		// Test result is correct url for snap file.
		
		// Test that file has been deleted off Caspar.
		
		// Test that file is present in snaps folder.
		
	}
	
}

?>