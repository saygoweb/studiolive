<?php

namespace models\mapper;

class MongoMapper
{
	/**
	 * @var MongoDB
	 */
	protected $_db;

	/**
	 * @var MongoCollection
	 */
	protected $_collection;
	
	/**
	 * @var string
	 */
	private $_idKey;

	/**
	 * @param string $database
	 * @param string $collection
	 * @param string $idKey defaults to id
	 */
	protected function __construct($database, $collection, $idKey = 'id')
	{
		$this->_db = MongoStore::connect($database);
		$this->_collection = $this->_db->$collection;
		$this->_idKey = $idKey;
	}
	
	/**
	 * Private clone to prevent copies of the singleton.
	 */
	private function __clone()
	{
	}

	/**
	 * Returns the name of the database.
	 * @return string
	 */
	public function databaseName() {
		return (string)$this->_db;
	}
	
	public function readList($model, $query, $fields = array())
	{
		$cursor = $this->_collection->find($query, $fields);
		$model->count = $cursor->count();
		$model->entries = array();
		foreach ($cursor as $item) {
			$id = strval($item['_id']);
			$item[$this->_idKey] = $id;
			unset($item['_id']);
			$model->entries[] = $item;
		}
	}
	
	/**
	 * @param Object $model
	 * @param string $id
	 */
	public function read($model, $id)
	{
		if (!is_string($id) || empty($id)) {
			$type = get_class($id);
			throw new Exception("Bad id '$id' ($type)");
		}		
		$data = $this->_collection->findOne(array("_id" => new \MongoId($id)));
		if ($data === NULL)
		{
			throw new \Exception("Could not find id '$id'");
		}
		$this->decode($model, $data);
	}
	
	public function write($model)
	{
		$data = $this->encode($model);
		return $this->update($this->_collection, $data, $model->id);
	}

	/**
	 * Sets the public properties of $model to values from $values[propertyName]
	 * @param object $model
	 * @param array $values
	 */
	public function decode($model, $values)
	{
		$properties = get_object_vars($model);
		$idKey = $this->_idKey;
		// Map the Mongo _id to the property $idKey
		if (array_key_exists($idKey, $properties))
		{
			$model->$idKey = strval($values['_id']);
			unset($properties[$idKey]);
		}
		foreach ($properties as $key => $value)
		{
			if (!array_key_exists($key, $values))
			{
				// oops // TODO Add to list, throw at end CP 2013-06
				continue;
			}
			$model->$key = $values[$key];
		}
	}

	/**
	 * Sets key/values in the array to the public properties of $model
	 * @param object $model
	 * @return array
	 */
	public function encode($model)
	{
		$data = array();
		$properties = get_object_vars($model);
		$idKey = $this->_idKey;
		// We don't want the 'idKey' in the data so remove that from the properties
		if (array_key_exists($idKey, $properties))
		{
			unset($properties[$idKey]);
		}
		foreach ($properties as $key => $value)
		{
			$data[$key] = $value;
		}
		return $data;
	}

	public function remove($id)
	{
		assert(is_string($id) && !empty($id));
		$result = $this->_collection->remove(
			array('_id' => new \MongoId($id)),
			array('safe' => true)
		);
		return $result['n'];
	}
	
	/**
	 *
	 * @param MongoCollection $collection
	 * @param array $data
	 * @param MongoId $id
	 * @return MongoId
	 */
	protected function update($collection, $data, $id)
	{
		if (!$id) {
			$id = NULL;
		}
		assert($id === NULL || is_string($id));
		$result = $collection->update(
				array('_id' => new \MongoId($id)),
				array('$set' => $data),
				array('upsert' => true, 'multiple' => false, 'safe' => true)
		);
		return isset($result['upserted']) ? $result['upserted'].$id : $id;
	}

}

?>