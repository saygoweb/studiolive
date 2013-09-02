<?php
namespace commands;

use libraries\palaso\CodeGuard;
use models\ActionModel;
use models\ShowModel;
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
	 * @param array $object
	 * @param string $operation
	 * @param array $sceneUserData
	 */
	public static function executeAction($object, $operation, $sceneUserData = null) {
		$action = new ActionModel();
		JsonDecoder::decode($action, $object);
		self::executeActionFromModel($action, $operation, $sceneUserData);
	}
	
	/**
	 * Executes the $operation using the $action with the given $sceneUserData. 
	 * @param array $object
	 * @param string $operation
	 * @param array $sceneUserData
	 */
	public static function executeActionFromModel($action, $operation, $sceneUserData = null) {
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
		$objectModel = CommandModel::createCommand($type);
		JsonDecoder::decode($objectModel, $object);
		switch ($operation) {
			case 'in':
				$caspar = CasparConnection::connect(CASPAR_HOST, CASPAR_PORT);
				$casparString = $commandModel->casparCommandIn(null);
				$caspar->sendString($casparString);
				break;
			case 'out':
				$caspar = CasparConnection::connect(CASPAR_HOST, CASPAR_PORT);
				$casparString = $commandModel->casparCommandOut();
				$caspar->sendString($casparString);
				break;
		}
	}
	
}

?>