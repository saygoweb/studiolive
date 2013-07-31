<?php

namespace models;

class CommandModel
{
	public function __construct() {
		$this->scenes = array();
	}

	/**
	 * Removes the record $id from the collection.
	 * @param string $id
	 * @return int The number of records removed from the collection.
	 */
	public static function remove($id) {
		return ShowModelMongoMapper::instance()->remove($id);
	}
	
	public static function createCommand($type) {
		switch ($type) {
			default:
				throw new \Exception("Unsupported type '$type'");
		}
	}

// 	public $id;

	public $type;
	
}

?>
