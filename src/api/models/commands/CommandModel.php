<?php

namespace models;

class CommandModel extends mapper\MapperModel
{
	public function __construct($id = NULL)
	{
		$this->scenes = array();
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

	public $id;

	public $type;
	
}

?>
