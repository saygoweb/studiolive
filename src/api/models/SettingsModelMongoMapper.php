<?php 

namespace models;

class SettingsModelMongoMapper extends mapper\MongoMapper
{
	public static function instance() {
		static $instance = null;
		if (null === $instance) {
			$instance = new SettingsModelMongoMapper(SL_DATABASE, 'settings');
		}
		return $instance;
	}
	
}

?>