<?php

namespace models;

class SceneModel extends mapper\MapperSubModel
{
	public function __construct($showId, $id = NULL)
	{
		$this->actions = array();
		$mapper = ShowModelMongoMapper::instance();
		parent::__construct($mapper, $showId, 'scenes', $id);
	}
	
	public function keyString() {
		return $this->name;
	}

	/**
	 * Removes the record $id from the collection.
	 * @param string $id
	 * @return int The number of records removed from the collection.
	 */
	public static function remove($showId, $id)
	{
		return ShowModelMongoMapper::instance()->removeSubDocument($showId, 'scenes', $id);
	}

	public $id;

	public $name;
	
	public $actions;

}

?>
