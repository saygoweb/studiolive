<?php

namespace models;

use models\mapper\ArrayOf;

class SceneModel extends mapper\MapperSubModel
{
	public function __construct($showId, $id = '') {
		$this->actions = new ArrayOf(ArrayOf::OBJECT, function($data) {
			return new ActionModel();
		});
		$mapper = ShowModelMongoMapper::instance();
		parent::__construct($mapper, $showId, 'scenes', $id);
	}
	
	public function keyString() {
		return $this->name;
	}

	/**
	 * Removes the record $id from the collection.
	 * @param string $id
	 * @return int The number of records removed from the collection.
	 */
	public static function remove($showId, $id) {
		return ShowModelMongoMapper::instance()->removeSubDocument($showId, 'scenes', $id);
	}

	public $id;

	public $name;
	
	public $actions;

}

?>
