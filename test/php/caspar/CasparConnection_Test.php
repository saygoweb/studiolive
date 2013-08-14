<?php

use models\mapper\caspar\CasparConnection;

require_once(dirname(__FILE__) . '/../TestConfig.php');
require_once(SIMPLE_TEST_PATH . 'autorun.php');

class TestCasparConnection extends UnitTestCase {

	const HOST = 'videotest';
	const PORT = '5250';
	
	function testSendCommand_USBCamera_Works() {
		$caspar = CasparConnection::connect(self::HOST, self::PORT);
		$command = 'PLAY 1-1 "BROADCAST NEWS"';
		$result = $caspar->sendString($command);
		var_dump($result);
	}
}

?>