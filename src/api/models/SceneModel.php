<?php

namespace models;

use models\mapper\Id;
use models\mapper\ArrayOf;
use models\mapper\MapOf;

class SceneModel
{
	public function __construct() {
		$this->id = new Id();
		$this->actions = new ArrayOf(ArrayOf::VALUE);
		$this->dataSet = new MapOf(function($data) {
			return new SceneActionDataItem();
		});
	}
	
	public $id;

	public $name;
	
	public $actions;

	public $dataSet;
	
}

?>
