<?php

namespace models;

use models\mapper\MongoMapper;
use models\mapper\ArrayOf;
use models\mapper\Id;
use models\mapper\MapOf;
use models\ActionModel;

class ShowModel extends mapper\MapperModel
{
	public function __construct($id = '') {
		$this->id = new Id();
		$this->actions = new MapOf(function($data) {
			return new ActionModel();
		});
		$this->scenes = new MapOf(function($data) {
			return new SceneModel();
		});
		$this->scenesIndex = new ArrayOf(ArrayOf::VALUE);
		parent::__construct(ShowModelMongoMapper::instance(), $id);
	}

	/**
	 * Removes the record $id from the collection.
	 * @param string $id
	 * @return int The number of records removed from the collection.
	 */
	public static function remove($id) {
		return ShowModelMongoMapper::instance()->remove($id);
	}
	
	public function read($id) {
		$result = parent::read($id);
		// Check the scenesIndex for sanity.
// 		if (count($this->scenes) != count($this->scenesIndex->data)) {
// 			error_log("ScenesIndex does not match");
// 			$this->scenesIndex->data = array_keys($this->scenes);
// 			$this->write();
// 		}
		return $result;
	}

	/**
	 * Reads a SceneModel 
	 * @param string $showId
	 * @param string $id
	 * @return SceneModel
	 */
	public static function readScene($showId, $id) {
		$mapper = ShowModelMongoMapper::instance();
		$sceneModel = new SceneModel();
		$mapper->readSubDocument($sceneModel, $showId, 'scenes', $id);
		return $sceneModel;
	}
	
	/**
	 * Writes (Updates) a SceneModel
	 * @param string $showId
	 * @param SceneModel $sceneModel
	 * @return string
	 */
	public static function writeScene($showId, $sceneModel) {
		$mapper = ShowModelMongoMapper::instance();
		$id = $sceneModel->id->asString();
		if (empty($id)) {
			$id = ShowModelMongoMapper::makeKey($sceneModel->name);
		}
		$mapper->write($sceneModel, $id, MongoMapper::ID_IN_KEY, $showId, 'scenes');
		return $id;
	}
	
	/**
	 * Removes a SceneModel
	 * @param string $showId
	 * @param string $id
	 */
	public static function removeScene($showId, $id) {
		$mapper = ShowModelMongoMapper::instance();
		return $mapper->removeSubDocument($showId, 'scenes', $id);
	}
	
	/**
	 * @param ActionModel $action
	 * @return string
	 */
	public static function updateAction($action) {
		if (Id::isEmpty($action->id)) {
			$action->id->id = MongoMapper::makeId();
		}
		$this->actions->data[$action->id->asString()] = $action;
		return $action->id->asString();
	}
	
	/**
	 * Writes (Updates) an ActionModel
	 * @param string $showId
	 * @param ActionModel $actionModel
	 * @return string
	 */
	public static function writeAction($showId, $actionModel) {
		$mapper = ShowModelMongoMapper::instance();
		$id = $actionModel->id->asString();
		if (empty($id)) {
			$id = ShowModelMongoMapper::makeId();
		}
		$mapper->write($actionModel, $id, MongoMapper::ID_IN_KEY, $showId, 'actions');
		return $id;
	}
	
	public static function removeAction($showId, $actionId) {
		$mapper = ShowModelMongoMapper::instance();
		return $mapper->removeSubDocument($showId, 'actions', $actionId);
	}
	
	public $id;

	public $name;
	
	public $scenesIndex;
	
	public $actions;
	
	public $scenes;

}

?>
