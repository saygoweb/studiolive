<?php
namespace commands;

use libraries\palaso\CodeGuard;
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
	public static function executeAction($showId, $sceneId, $actionId, $operation) {
		$showModel = new ShowModel($showId);
		$action = $showModel->actions->data[$actionId];
		switch ($operation) {
			case 'in':
				$sceneUserData = null;
				if ($sceneId) {
					$scene = $showModel->scenes->data[$sceneId];
					if (key_exists($actionId, $scene->dataSet->data)) {
						$actionDataItem = $scene->dataSet->data[$actionId];
						$sceneUserData = $actionDataItem->data->data;
					}
				}
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
	
	public static function executeCommand($command, $operation) {
		$type = $command['type'];
		CodeGuard::checkTypeAndThrow($type, 'string');
		$commandModel = CommandModel::createCommand($type);
		JsonDecoder::decode($commandModel, $command);
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