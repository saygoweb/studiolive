<?php

namespace models;

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

?>
