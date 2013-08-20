<?php

namespace models;

use models\mapper\Id;
use models\mapper\ArrayOf;
use models\mapper\MapOf;

class SceneDataItem
{
	/**
	 * @var string
	 */
	public $name;
	
	/**
	 * @var string
	 */
	public $value;
}

class SceneActionDataItem
{
	public function __construct() {
		$this->data = new MapOf(function($data) {
			return new SceneDataItem();
		});
	}
	
	public $data;
}

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
