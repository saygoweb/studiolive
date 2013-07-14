<?php

use models\SceneModel;

use commands\ShowCommands;

require_once(dirname(__FILE__) . '/Config.php');

use lib\JsonRpcServer;

class StudioLiveAPI
{
	
	public function __construct()
	{
		// TODO put in the LF style error handler for logging / jsonrpc return formatting etc. CP 2013-07
		ini_set('display_errors', 0);
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
		JsonRpcServer::decode($show, $object);
		$result = $show->write();
		return $result;
	}

	/**
	 * Read a show from the given $id
	 * @param string $id
	 */
	public function show_read($id) {
		$show = new \models\ShowModel($id);
		return $show;
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
	
	//---------------------------------------------------------------
	// SCENE API
	//---------------------------------------------------------------
	
	public function scene_read($showId, $sceneId) {
		$scene = new \models\SceneModel($showId, $sceneId);
		return $scene;
	}
	
	public function scene_update($showId, $object) {
		$scene = new \models\SceneModel($showId);
		JsonRpcServer::decode($scene, $object);
		$result = $scene->write();
		return $result;
	}
	
	public function scene_delete($showId, $sceneIds) {
 		$result = ShowCommands::deleteScenes($showId, $sceneIds);
		return $result;
	}

}

function main() {
	$api = new StudioLiveAPI();
	JsonRpcServer::handle($api);
}

main();

?>