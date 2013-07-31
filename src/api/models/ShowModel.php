<?php

namespace models;

use models\mapper\ArrayOf;

use models\mapper\Id;

class ShowModel extends mapper\MapperModel
{
	public function __construct($id = '') {
		$this->id = new Id();
		$this->scenesIndex = new ArrayOf(ArrayOf::VALUE);
		$this->actions = new ArrayOf(ArrayOf::OBJECT, function($data) {
			return new ActionModel();
		});
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
		if (count($this->scenes) != count($this->scenesIndex->data)) {
			error_log("ScenesIndex does not match");
			$this->scenesIndex->data = array_keys($this->scenes);
			$this->write();
		}
		return $result;
	}

	public $id;

	public $name;
	
	public $scenesIndex;
	
	public $actions;
	
	public $scenes;

}

?>
