<?php
namespace models\dto;

use models\ResourceModel;

use models\mapper\ArrayOf;

use commands\ResourceCommands;
use models\SettingsModel;
use models\ShowModel;

class ShowDto {
	public function __construct($showId) {
		$this->show = new ShowModel($showId);
		$this->settings = new SettingsModel();
		$this->settings->readOrCreate(SettingsModel::DEFAULT_PROFILE);
 		$this->resources = new ArrayOf(ArrayOf::OBJECT, function($data) {
 			return new ResourceModel();
 		});
 		//$this->resources->data = ResourceCommands::listResources();
	}
	
	public $show;
	
	public $settings;
	
	public $resources;
	
}