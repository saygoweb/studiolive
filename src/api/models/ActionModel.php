<?php
namespace models;

use models\commands\CommandModel;
use models\mapper\ArrayOf;

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