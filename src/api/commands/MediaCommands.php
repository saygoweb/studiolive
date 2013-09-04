<?php
namespace commands;

use libraries\palaso\CodeGuard;
use models\mapper\caspar\CasparConnection;
use models\mapper\JsonDecoder;

class MediaCommands {
	
	/**
	 * @return array array<string>
	 */
	public static function listImages() {
		return self::listCaspar('CLS', 'STILL');
	}
	
	public static function listVideo() {
		return self::listCaspar('CLS', 'MOVIE');
	}
	
	public static function listFlash() {
		return self::listCaspar('TLS', '');
	}
	
	private static function listCaspar($command, $match) {
		$caspar = CasparConnection::connect(CASPAR_HOST, CASPAR_PORT);
		$response = $caspar->sendString($command, CasparConnection::MULTI_LINE_RESPONSE);
		if ($response[0] != "200 $command OK") {
			throw new \Exception("Caspar Error: " . $response[0]);
		}
		unset($response[0]);
		$result = [];
		foreach ($response as $line) {
			$tokens = $array = preg_split('/(?: +|(=))(?=(?:[^"]*"[^"]*")*[^"]*$)/', $line, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
// 			var_dump($tokens);
			if (empty($match) || $tokens[1] == $match) {
				$result[] = trim($tokens[0], '"');
			}
		}
		return $result;
	}
	
}

?>