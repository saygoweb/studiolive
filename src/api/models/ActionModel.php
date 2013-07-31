<?php

use models\CommandModel;

class ActionModel
{
	public function __construct() {
		$this->commands = new ArrayOf(ArrayOf::OBJECT, function($data) {
			return CommandModel::createCommand($data['type']);
		});
	}
	
	public $commands;
}

?>