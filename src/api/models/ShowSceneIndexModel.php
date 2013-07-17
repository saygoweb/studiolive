<?php

namespace models;

class ShowSceneIndexModel extends mapper\MapperModel
{
	public function __construct($id)
	{
		$this->scenesIndex = array();
		parent::__construct(ShowModelMongoMapper::instance(), $id);
	}

	public $id;

	public $scenesIndex;
	
}

?>
