<?php

namespace models\commands;

class InputResourceCommandModel extends InputCommandModel
{
	public function casparCommandIn() {
		$result = sprintf('PLAY %d-%d "%s"', $this->channel, $this->layer, $this->resourceName);
		return $result;
	}
	
	public function casparCommandOut() {
		$result = sprintf('STOP %d-%d', $this->channel, $this->layer);
		return $result;
	}

	public $resourceName;
	
}

?>
