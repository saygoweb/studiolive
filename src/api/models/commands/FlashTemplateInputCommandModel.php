<?php

namespace models\commands;

use models\mapper\ArrayOf;

class FlashTemplateData
{
	public $name;
	
	public $fieldId;
	
	public $defaultValue;
	
	public $useDefaultOnly;
	
}

class FlashTemplateInputCommandModel extends InputResourceCommandModel
{
	
	public function __construct() {
		$this->dataSet = new ArrayOf(ArrayOf::OBJECT, function($data) {
			return new FlashTemplateData();
		});
	}
	
	public $dataSet;

	
}

?>
