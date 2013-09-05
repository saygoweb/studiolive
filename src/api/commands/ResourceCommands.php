<?php
namespace commands;

use models\ResourceModel;

use libraries\palaso\CodeGuard;
use models\mapper\caspar\CasparConnection;
use models\mapper\JsonDecoder;

class ResourceCommands {
	
	/**
	 * @return array array<string>
	 */
	/*
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
	*/

	public static function listResources() {
		$resultCLS = self::listCasparWithType('CLS');
		$resultTLS = self::listCasparWithType('TLS');
		return array_merge($resultCLS, $resultTLS);
	}
	
	private static function listCasparWithType($command) {
		static $map = array(
				'STILL' => ResourceModel::TYPE_IMAGE,
				'MOVIE' => ResourceModel::TYPE_VIDEO,
				'FLASH' => ResourceModel::TYPE_FLASH
		);
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
			if ($command == 'CLS') {
				$type = $tokens[1];
			} else {
				$type = 'FLASH';
			}
			$model = new ResourceModel();
			$model->resourceName = trim($tokens[0], '"');
			$type = ($command == 'CLS') ? $tokens[1] : 'FLASH';
			$model->type = $map[$type];
			$result[] = $model;
		}
		return $result;
	}
	
	
	
}

?>