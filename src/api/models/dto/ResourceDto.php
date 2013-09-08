<?php
namespace models\dto;

use libraries\palaso\CodeGuard;
use models\mapper\ArrayOf;
use models\ResourceModel;
use models\mapper\caspar\CasparConnection;

class ResourceDto {
	
	public function __construct() {
		$this->resources = new ArrayOf(ArrayOf::OBJECT, function($data) {
 			return new ResourceModel();
 		});
		$this->resources->data = self::listResources();
	}
	
	private static function listResources() {
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
	
	/**
	 * @var ArrayOf ArrayOf<ResourceModel>
	 */
	public $resources;
	
}

?>