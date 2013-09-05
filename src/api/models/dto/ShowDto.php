<?php
namespace models\dto;

use commands\MediaCommands;

use models\SettingsModel;

use models\ShowModel;

class ShowDto {
	public function __construct($showId) {
		$this->show = new ShowModel($showId);
		$this->settings = new SettingsModel();
		$this->settings->readOrCreate(SettingsModel::DEFAULT_PROFILE);
// 		$this->resources = MediaCommands::listResources();
	}
	
	public $show;
	
	public $settings;
	
	public $resources;
	
}