<?php
namespace models;

use models\mapper\ArrayOf;
use models\mapper\Id;

class PreviewSetting
{
	public $channel;
	
	public $urlRx;
	
	public $urlTx;
	
	
}

class CameraSetting
{
	public $name;
	
	public $uri;
}

class SettingsModel extends mapper\MapperModel
{
	const DEFAULT_PROFILE = '0';
	
	public function __construct() {
		$this->id = new Id();
		$this->cameras = new ArrayOf(ArrayOf::OBJECT, function($data) {
			return new CameraSetting();
		});
		$this->previews = new ArrayOf(ArrayOf::OBJECT, function($data) {
			return new PreviewSetting();
		});
		parent::__construct(ShowModelMongoMapper::instance(), self::DEFAULT_PROFILE);
	}

	public $id;

	public $cameras;
	
	public $previews;
	
}

?>