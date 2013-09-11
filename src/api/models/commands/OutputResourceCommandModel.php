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
		$options = '';
		$result = sprintf('ADD %d %s "%s" %s', $this->channel, $this->_type, $this->resourceName, $options);
		return $result;
	}
	
	public function casparCommandOut() {
		$resourceName = $this->resourceName;
		if ($this->_type == self::FILE) {
			// Hmmm, 'REMOVE 1 FILE $this->resourceName' throws, but any non existent name works. 
			$resourceName = '_x';
		}
		$result = sprintf('REMOVE %d %s "%s"', $this->channel, $this->_type, $resourceName);
		return $result;
	}
	
	public $channel;
	
	public $resourceName;

	/*
	public $size;
	
	public $videoCodec;
	
	public $audioCodec;
	*/
	
}

?>
