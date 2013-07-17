<?php

namespace models\mapper;

class MapperModel
{
	protected $_mapper;

	protected function __construct($mapper, $id = NULL) {
		$this->_mapper = $mapper;
		if (!empty($id))
		{
			$this->read($id);
		}
	}
	
	/**
	 * Reads the model from the mongo collection
	 * @see MongoMapper::read()
	 */
	public function read($id) {
		return $this->_mapper->read($this, $id);
	}
	
	/**
	 * Writes the model to the mongo collection
	 * @return string The unique id of the object written
	 * @see MongoMapper::write()
	 */
	public function write() {
		$this->id = $this->_mapper->write($this);
		return $this->id;
	}
	
}

?>