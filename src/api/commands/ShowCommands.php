<?php

namespace commands;

use libraries\palaso\CodeGuard;

use models\mapper\JsonDecoder;
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
		CodeGuard::checkTypeAndThrow($sceneIds, 'array');
		$count = 0;
		foreach ($sceneIds as $sceneId) {
			CodeGuard::checkTypeAndThrow($sceneId, 'string');
			SceneModel::remove($showId, $sceneId);
			$count++;
		}
		$sceneIndex = new \models\ShowSceneIndexModel($showId);
		// Note: we use array_values here to normalize the array. see http://stackoverflow.com/questions/369602/how-to-delete-an-element-from-an-array-in-php
		$sceneIndex->scenesIndex->data = array_values(array_diff($sceneIndex->scenesIndex->data, $sceneIds));
		$sceneIndex->write();
		return $count;
	}

	public static function updateScene($showId, $object) {
		$scene = new \models\SceneModel($showId);
		JsonDecoder::decode($scene, $object);
		$newScene = empty($scene->id);
		$sceneId = $scene->write();
		if ($newScene) {
			$sceneIndex = new \models\ShowSceneIndexModel($showId);
			$sceneIndex->scenesIndex->append($sceneId);
			$sceneIndex->write();
		}
		return $sceneId;
	}

}

?>