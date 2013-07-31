<?php

namespace models;

use models\mapper\ArrayOf;
use models\mapper\Id;

class ShowSceneIndexModel extends mapper\MapperModel
{
	public function __construct($id ) {
		$this->id = new Id();
		$this->scenesIndex = new ArrayOf(ArrayOf::VALUE);
		parent::__construct(ShowModelMongoMapper::instance(), $id);
	}

	public $id;

	public $scenesIndex;
	
}

?>
