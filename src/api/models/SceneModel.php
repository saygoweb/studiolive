<?php

namespace models;

use models\mapper\ArrayOf;

class SceneModel
{
	public function __construct() {
		$this->actions = new ArrayOf(ArrayOf::VALUE);
	}
	
	public $id;

	public $name;
	
	public $actions;

}

?>
