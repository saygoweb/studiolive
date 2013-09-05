<?php 

namespace models;

class ResourceMongoMapper extends mapper\MongoMapper
{
	public static function instance() {
		static $instance = null;
		if (null === $instance) {
			$instance = new ResourceMongoMapper(SL_DATABASE, 'resources');
		}
		return $instance;
	}
	
}

?>