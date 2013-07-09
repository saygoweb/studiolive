<?php 

namespace models;

class ShowModelMongoMapper extends mapper\MongoMapper
{
	public static function instance()
	{
		static $instance = null;
		if (null === $instance)
		{
			$instance = new ShowModelMongoMapper(SL_DATABASE, 'shows');
		}
		return $instance;
	}
	
}

?>