<?php

use commands\CasparCommands;
use commands\ShowCommands;
use libraries\palaso\JsonRpcServer;
use models\ActionModel;
use models\SceneModel;
use models\SettingsModel;
use models\ShowModel;
use models\ShowSceneIndexModel;
use models\dto\ResourceDto;
use models\dto\ShowDto;
use models\mapper\JsonDecoder;
use models\mapper\JsonEncoder;

class StudioLiveAPI
{
	
	public function __construct() {
		// TODO put in the LF style error handler for logging / jsonrpc return formatting etc. CP 2013-07
		ini_set('display_errors', 0);
	}

	//---------------------------------------------------------------
	// SETTINGS API
	//---------------------------------------------------------------
	public function settings_update($object) {
		$id = $object['id'];
		$settings = new SettingsModel(SettingsModel::DEFAULT_PROFILE);
		JsonDecoder::decode($settings, $object);
		$settings->write();
	}
	
	public function settings_read() {
		$settings = new SettingsModel();
		$settings->readOrCreate(SettingsModel::DEFAULT_PROFILE);
		return JsonEncoder::encode($settings);
	}	
	
	//---------------------------------------------------------------
	// SHOW API
	//---------------------------------------------------------------
	
	/**
	 * Create/Update a User
	 * @param ShowModel $object
	 * @return string Id of written object
	 */
	public function show_update($object) {
		$show = new \models\ShowModel();
		JsonDecoder::decode($show, $object);
		$result = $show->write();
		return $result;
	}

	/**
	 * Read a ShowDto from the given $id
	 * @param string $id
	 * @see ShowDto
	 */
	public function show_read($id) {
		$show = new ShowDto($id);
		return JsonEncoder::encode($show);
	}
	
	/**
	 * Delete multiple shows
	 * @param array<string> $showIds
	 * @return int Total number of deleted shows.
	 */
 	public function show_delete($showIds) {
 		$result = ShowCommands::deleteShows($showIds);
		return $result;
 	}

	// TODO Pretty sure this is going to want some paging params
	public function show_list() {
		$list = new \models\ShowListModel();
		$list->read();
		return $list;
	}
	
	public function show_updateAction($showId, $action) {
		$actionModel = new ActionModel();
		JsonDecoder::decode($actionModel, $action);
		return ShowModel::writeAction($showId, $actionModel);
	}
	
	public function show_removeAction($showId, $actionId) {
		return ShowModel::removeAction($showId, $actionId);
	}
	
	public function show_updateScenesIndex($showId, $scenesIndex) {
		$sceneIndex = new ShowSceneIndexModel($showId);
		// Check that the length is the same. Should really check that the contents are the same but this will do.
		$expected = $sceneIndex->scenesIndex->count();
		$actual = count($scenesIndex);
		if ($actual != $expected) {
			throw new \Exception("Expected $expected items in index, $actual given.");
		}
		$sceneIndex->scenesIndex->data = $scenesIndex;
		$sceneIndex->write();
		return true;
	}
	
	//---------------------------------------------------------------
	// SCENE API
	//---------------------------------------------------------------
	
	public function scene_read($showId, $sceneId) {
		$scene = ShowModel::readScene($showId, $sceneId);
		return JsonEncoder::encode($scene);
	}
	
	public function scene_update($showId, $object) {
		return ShowCommands::updateScene($showId, $object);
	}
	
	public function scene_delete($showId, $sceneIds) {
 		$result = ShowCommands::deleteScenes($showId, $sceneIds);
		return $result;
	}
	
	public function scene_executeAction($showId, $sceneId, $actionId, $operation) {
		CasparCommands::executeActionFromShow($showId, $sceneId, $actionId, $operation);
	}
	
	//---------------------------------------------------------------
	// CASPAR API
	//---------------------------------------------------------------
	
	public function caspar_executeAction($action, $operation, $sceneUserData) {
		CasparCommands::executeAction($action, $operation, $sceneUserData);
	}
	
	public function caspar_executeCommand($command, $operation) {
		CasparCommands::executeCommand($command, $operation);
	}
	
	public function caspar_listResources() {
		$resources = new ResourceDto();
		return JsonEncoder::encode($resources);
	}
	
	public function caspar_ping() {
		$state = CasparCommands::state();
		return JsonEncoder::encode($state);
	}

	public function snap($channel, $fileName) {
		return CasparCommands::snap($channel, $fileName);
	}
	
	public function snap_update($fileName, $newFileName, $assignees) {
		throw new \Exception("NYI");
	}

}

function main() {
	$api = new StudioLiveAPI();
	JsonRpcServer::handle($api);
}

main();

?>