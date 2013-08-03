<?php

namespace models;

use models\mapper\Id;

use models\mapper\ArrayOf;

class SceneModel
{
	public function __construct() {
		$this->id = new Id();
		$this->actions = new ArrayOf(ArrayOf::VALUE);
	}
	
	public $id;

	public $name;
	
	public $actions;

}

?>
