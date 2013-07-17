<?php

namespace commands;

use lib\JsonRpcServer;
use models\SceneModel;
use models\ShowModel;
use models\ShowSceneIndexModel;

class ShowCommands
{
	/**
	 * @param array $showIds
	 * @return int Total number of shows removed.
	 */
	public static function deleteShows($showIds) {
		$count = 0;
		foreach ($showIds as $showId) {
			ShowModel::remove($showId);
			$count++;
		}
		return $count;
	}	

	/**
	 * @param string $showId
	 * @param array $sceneIds
	 * @return int Total number of scenes removed.
	 */
	public static function deleteScenes($showId, $sceneIds) {
		$count = 0;
		foreach ($sceneIds as $sceneId) {
			SceneModel::remove($showId, $sceneId);
			$count++;
		}
		$sceneIndex = new \models\ShowSceneIndexModel($showId);
		$sceneIndex->scenesIndex = array_diff($sceneIndex->scenesIndex, $sceneIds);
		$sceneIndex->write();
		return $count;
	}

	public static function updateScene($showId, $object) {
		$scene = new \models\SceneModel($showId);
		JsonRpcServer::decode($scene, $object);
		$newScene = empty($scene->id);
		$sceneId = $scene->write();
		if ($newScene) {
			$sceneIndex = new \models\ShowSceneIndexModel($showId);
			$sceneIndex->scenesIndex[] = $sceneId;
			$sceneIndex->write();
		}
		return $sceneId;
	}

}

?>