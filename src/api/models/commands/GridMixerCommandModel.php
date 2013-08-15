<?php

namespace models\commands;

class GridMixerCommandModel extends InputCommandModel
{
	public function casparCommandIn() {
		$result = sprintf('MIXER %d GRID %d', $this->channel, $this->gridSize);
		return $result;
	}
	
	public function casparCommandOut() {
		$result = sprintf('MIXER %d GRID 1', $this->channel);
		return $result;
	}

	public $gridSize;
	
}

?>
