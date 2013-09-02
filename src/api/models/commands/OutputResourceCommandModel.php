<?php

namespace models\commands;

class OutputResourceCommandModel extends CommandModel
{
	
	const FILE   = 'FILE';
	const STREAM = 'STREAM';
	
	private $_type;
	
	public function __construct($type) {
		$this->_type = $type;
		$this->options = '';
	}
	
	public function casparCommandIn($userData) {
		// TODO Add support for arbitrary args
		$result = sprintf('ADD %d %s "%s" %s', $this->channel, $this->_type, $this->resourceName, $this->options);
		return $result;
	}
	
	public function casparCommandOut() {
		$result = sprintf('REMOVE %d %s "%s"', $this->channel, $this->_type, $this->resourceName);
		return $result;
	}
	
	public $channel;
	
	public $resourceName;
	
	public $options;
	
}

?>
