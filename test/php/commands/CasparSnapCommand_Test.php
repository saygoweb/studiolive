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
			return array($this->response);
		}
	}
	
}

class TestCasparSnapCommand extends UnitTestCase {

	private $_environment;
	
	function __construct() {
		$this->_environment = new CasparSnapTestConnection();
		CasparConnection::connect(CASPAR_HOST, CASPAR_PORT, $this->_environment);
	}
	
	function testSnapCommand() {
		$command = new CasparSnapCommand();
		$result = $command->snap(1);
		
		// Test result is correct url for snap file.
		$expectedFileName = $this->_environment->dateTime->format('Ymd\THis') . '.png';
		$expectedFilePath = '/images/snap/' . $expectedFileName;
		$this->assertEqual($expectedFilePath, $result);

		// Test that file has been deleted off Caspar.
		$exists = file_exists(CASPAR_PATH_SNAP . DIRECTORY_SEPARATOR . $expectedFileName);
		$this->assertFalse($exists, "File $expectedFileName should have been deleted from Caspar");
		
		// Test that file is present in snaps folder.
		$exists = file_exists(SL_PATH_SNAP . DIRECTORY_SEPARATOR . $expectedFileName);
		$this->assertTrue($exists);
		
		unlink(SL_PATH_SNAP . DIRECTORY_SEPARATOR . $expectedFileName);
	}
	
}

?>