<?php

namespace commands;

use models\mapper\Id;

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
			ShowModel::removeScene($showId, $sceneId);
			$count++;
		}
		$sceneIndex = new \models\ShowSceneIndexModel($showId);
		// Note: we use array_values here to normalize the array. see http://stackoverflow.com/questions/369602/how-to-delete-an-element-from-an-array-in-php
		$sceneIndex->scenesIndex->data = array_values(array_diff($sceneIndex->scenesIndex->data, $sceneIds));
		$sceneIndex->write();
		return $count;
	}

	public static function updateScene($showId, $object) {
		$scene = new SceneModel();
		JsonDecoder::decode($scene, $object);
		$newScene = Id::isEmpty($scene->id);
		$sceneId = ShowModel::writeScene($showId, $scene);
		if ($newScene) {
			$sceneIndex = new \models\ShowSceneIndexModel($showId);
			$sceneIndex->scenesIndex->append($sceneId);
			$sceneIndex->write();
		}
		return $sceneId;
	}

}

?>