<?php

use models\commands\USBCameraInputCommandModel;

use models\commands\VideoFileInputCommandModel;
use models\mapper\caspar\CasparConnection;

require_once(dirname(__FILE__) . '/../TestConfig.php');
require_once(SIMPLE_TEST_PATH . 'autorun.php');

class TestCasparCommand extends UnitTestCase {

	const HOST = 'videotest';
	const PORT = '5250';
	
	private function toCaspar($command) {
		$caspar = CasparConnection::connect(self::HOST, self::PORT);
		$result = $caspar->sendString($command);
		var_dump($result);
	}
	
	function testCasparCommand_VideoFileInputCommand() {
		$command = new VideoFileInputCommandModel();
		$command->channel = 1;
		$command->layer = 1;
		$command->resouceName = 'BROADCAST NEWS';
		
		$result = $command->casparCommandIn();
		$this->assertEqual("PLAY 1-1 \"BROADCAST NEWS\"", $result);
		var_dump($result);
		
		//$this->toCaspar($result);
	}
	
	function testCasparCommand_USBCameraInputCommand() {
		$command = new USBCameraInputCommandModel();
		$command->channel = 1;
		$command->layer = 1;
		$command->resouceName = 'dshow://video=Sony Visual Communication Camera';
		
		$result = $command->casparCommandIn();
		$this->assertEqual("PLAY 1-1 \"dshow://video=Sony Visual Communication Camera\"", $result);
		var_dump($result);
		
		$this->toCaspar($result);
	}
	
}

?>