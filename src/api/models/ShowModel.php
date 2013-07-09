<?php

namespace models;

class ShowModel extends mapper\MapperModel
{
	public function __construct($id = NULL)
	{
		$this->projects = array();
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

	public $name;

}

?>
