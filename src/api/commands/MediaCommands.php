<?php
namespace commands;

use libraries\palaso\CodeGuard;
use models\mapper\caspar\CasparConnection;
use models\mapper\JsonDecoder;

class MediaCommands {
	
	public static function listImages() {
		$caspar = CasparConnection::connect(CASPAR_HOST, CASPAR_PORT);
		$result = $caspar->sendString('CLS');
		return $result;
	}
	
}

?>