<?php

namespace models;

class ShowModel extends mapper\MapperModel
{
	public function __construct($id = NULL)
	{
		$this->scenesIndex = array();
		$this->scenes = new \stdClass();
		$this->actions = array();
		parent::__construct(ShowModelMongoMapper::instance(), $id);
	}

	/**
	 * Removes the record $id from the collection.
	 * @param string $id
	 * @return int The number of records removed from the collection.
	 */
	public static function remove($id)
	{
		return ShowModelMongoMapper::instance()->remove($id);
	}
	
	public function read($id) {
		$result = parent::read($id);
		// Check the scenesIndex for sanity.
		if (count($this->scenes) != count($this->scenesIndex)) {
			error_log("ScenesIndex does not match");
			$this->scenesIndex = array_keys($this->scenes);
			$this->write();
		}
		return $result;
	}

	public $id;

	public $name;
	
	public $scenesIndex;
	
	public $scenes;
	
	public $actions;

}

?>
