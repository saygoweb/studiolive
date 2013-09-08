<?php
namespace commands;

use libraries\palaso\CodeGuard;
use models\ActionModel;
use models\SceneActionDataItem;
use models\ShowModel;
use models\StateModel;
use models\mapper\caspar\CasparConnection;
use models\mapper\JsonDecoder;
use models\commands\CommandModel;

class CasparCommands {
	
	/**
	 * Creates the Caspar AMCP string and sends that to the server. 
	 * @param string $showId
	 * @param string $sceneId
	 * @param string $actionId
	 * @param string $operation
	 */
	public static function executeActionFromShow($showId, $sceneId, $actionId, $operation) {
		$showModel = new ShowModel($showId);
		$action = $showModel->actions->data[$actionId];
		$sceneUserData = null;
		if ($sceneId && $operation == 'in') {
			$scene = $showModel->scenes->data[$sceneId];
			if (key_exists($actionId, $scene->dataSet->data)) {
				$actionDataItem = $scene->dataSet->data[$actionId];
				$sceneUserData = $actionDataItem->data->data;
			}
		}
		self::executeActionFromModel($action, $operation, $sceneUserData);
	}
	
	/**
	 * Executes the $operation using the action defined by the JSON $object with the given $sceneUserData.
	 * @param array $object JSON array
	 * @param string $operation
	 * @param array $sceneUserData
	 */
	public static function executeAction($object, $operation, $sceneUserData = null) {
		$action = new ActionModel();
		JsonDecoder::decode($action, $object);
// 		var_dump($sceneUserData);
		if ($sceneUserData !== null) {
			$sceneUserDataModel = new SceneActionDataItem();
			JsonDecoder::decode($sceneUserDataModel, $sceneUserData);
			self::executeActionFromModel($action, $operation, $sceneUserDataModel->data->data);
		} else {
			self::executeActionFromModel($action, $operation);
		}
	}
	
	/**
	 * Executes the $operation using the $action with the given $sceneUserData. 
	 * @param array $object
	 * @param string $operation
	 * @param array $sceneUserData array('f0' => 'value0', ...)
	 */
	public static function executeActionFromModel($action, $operation, $sceneUserData = null) {
		if ($sceneUserData !== null) {
			CodeGuard::checkTypeAndThrow($sceneUserData, 'array');
		}
		switch ($operation) {
			case 'in':
				$caspar = CasparConnection::connect(CASPAR_HOST, CASPAR_PORT);
				foreach ($action->commands->data as $command) {
					$casparString = $command->casparCommandIn($sceneUserData);
					$caspar->sendString($casparString);
				}
				break;
			case 'out':
				$caspar = CasparConnection::connect(CASPAR_HOST, CASPAR_PORT);
				foreach ($action->commands->data as $command) {
					$casparString = $command->casparCommandOut();
					$caspar->sendString($casparString);
				}
				break;
			case 'update':
				$caspar = CasparConnection::connect(CASPAR_HOST, CASPAR_PORT);
				foreach ($action->commands->data as $command) {
					$casparString = $command->casparCommandUpdate($sceneUserData);
					$caspar->sendString($casparString);
				}
				break;
			default:
				throw new \Exception("Unsupported Caspar operation '$operation'");
		}
	}
	
	/**
	 * Executes the $operation defined by the JSON $object.
	 * @param array $object
	 * @param string $operation
	 */
	public static function executeCommand($object, $operation) {
		$type = $object['type'];
		CodeGuard::checkTypeAndThrow($type, 'string');
		$command = CommandModel::createCommand($type);
		JsonDecoder::decode($command, $object);
		switch ($operation) {
			case 'in':
				$caspar = CasparConnection::connect(CASPAR_HOST, CASPAR_PORT);
				$casparString = $command->casparCommandIn(null);
				$caspar->sendString($casparString);
				break;
			case 'out':
				$caspar = CasparConnection::connect(CASPAR_HOST, CASPAR_PORT);
				$casparString = $command->casparCommandOut();
				$caspar->sendString($casparString);
				break;
		}
	}
	
	public static function state() {
		$state = new StateModel();
		try {
			$caspar = CasparConnection::connect(CASPAR_HOST, CASPAR_PORT);
			$caspar->sendString("\r\n", CasparConnection::SINGLE_LINE_RESPONSE);
			$state->connected = true;
		} catch (\Exception $e) {
			$state->connected = false;
		}
		return $state;
	}
	
	/**
	 * 
	 * @param int $channel
	 */
	public static function snap($channel) {
		$caspar = CasparConnection::connect(CASPAR_HOST, CASPAR_PORT);
		$caspar->sendString("PRINT $channel\r\n", CasparConnection::SINGLE_LINE_RESPONSE);
		
	}
	
}

?>