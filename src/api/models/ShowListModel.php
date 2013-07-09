<?php

namespace models;

class ShowListModel extends mapper\MapperListModel
{

	public function __construct()
	{
		parent::__construct(
				ShowModelMongoMapper::instance(),
				array('name' => array('$regex' => '')),
				array('name')
		);
	}

}

?>