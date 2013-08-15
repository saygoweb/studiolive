<?php

use models\commands\StreamInputCommandModel;

use models\commands\ImageInputCommandModel;

use models\commands\FlashTemplateInputCommandModel;

use models\commands\RouteMixerCommandModel;

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
	
	function testCasparCommand_FlashTemplateInputCommand() {
		$command = new FlashTemplateInputCommandModel();
		$command->channel = 1;
		$command->layer = 1;
		$command->resourceName = 'Some Template';
		
		$result = $command->casparCommandIn();
		$this->assertEqual("PLAY 1-1 \"Some Template\"", $result);
// 		var_dump($result);
		
// 		$this->toCaspar($result);

		$result = $command->casparCommandOut();
		$this->assertEqual("STOP 1-1", $result);
	}
	
	function testCasparCommand_ImageInputCommand() {
		$command = new ImageInputCommandModel();
		$command->channel = 1;
		$command->layer = 1;
		$command->resourceName = 'CHIANGMAI_ONLINE';
		
		$result = $command->casparCommandIn();
		$this->assertEqual("PLAY 1-1 \"CHIANGMAI_ONLINE\"", $result);
// 		var_dump($result);
		
// 		$this->toCaspar($result);

		$result = $command->casparCommandOut();
		$this->assertEqual("STOP 1-1", $result);
	}
	
	function testCasparCommand_StreamInputCommand() {
		$command = new StreamInputCommandModel();
		$command->channel = 1;
		$command->layer = 1;
		$command->resourceName = 'rtp://@:5004';
		
		$result = $command->casparCommandIn();
		$this->assertEqual("PLAY 1-1 \"rtp://@:5004\"", $result);
// 		var_dump($result);
		
// 		$this->toCaspar($result);

		$result = $command->casparCommandOut();
		$this->assertEqual("STOP 1-1", $result);
	}
	
	function testCasparCommand_USBCameraInputCommand() {
		$command = new USBCameraInputCommandModel();
		$command->channel = 1;
		$command->layer = 1;
		$command->resourceName = 'dshow://video=Sony Visual Communication Camera';
		
		$result = $command->casparCommandIn();
		$this->assertEqual("PLAY 1-1 \"dshow://video=Sony Visual Communication Camera\"", $result);
// 		var_dump($result);
		
// 		$this->toCaspar($result);
		$result = $command->casparCommandOut();
		$this->assertEqual("STOP 1-1", $result);
	}
	
	function testCasparCommand_VideoFileInputCommand() {
		$command = new VideoFileInputCommandModel();
		$command->channel = 1;
		$command->layer = 1;
		$command->resourceName = 'BROADCAST NEWS';
		
		$result = $command->casparCommandIn();
		$this->assertEqual("PLAY 1-1 \"BROADCAST NEWS\"", $result);
// 		var_dump($result);
		
// 		$this->toCaspar($result);

		$result = $command->casparCommandOut();
		$this->assertEqual("STOP 1-1", $result);
	}
	
	function testCasparCommand_RouteMixerCommand() {
		$command = new RouteMixerCommandModel();
		$command->channel = 2;
		$command->layer = 1;
		$command->srcChannel = 1;
		
		$result = $command->casparCommandIn();
		$this->assertEqual("ROUTE 2-1 route://1", $result);
// 		var_dump($result);

		$command->srcLayer = 1;
		
		$result = $command->casparCommandIn();
		$this->assertEqual("ROUTE 2-1 route://1-1", $result);
// 		var_dump($result);
		
// 		$this->toCaspar($result);

		$result = $command->casparCommandOut();
		$this->assertEqual("STOP 2-1", $result);
	}
	
}

?>