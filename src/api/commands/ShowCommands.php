<?php

namespace commands;

use models\SceneModel;
use models\ShowModel;

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
		return $count;
	}	

}

?>