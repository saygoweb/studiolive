<?php
namespace models;

use models\commands\CommandModel;
use models\mapper\ArrayOf;
use models\mapper\Id;

class ActionModel
{
	public function __construct() {
		$this->id = new Id();
		$this->commands = new ArrayOf(ArrayOf::OBJECT, function($data) {
			return CommandModel::createCommand($data['type']);
		});
	}
	
	public $id;
	
	public $name;
	
	public $commands;
}

?>