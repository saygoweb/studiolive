<?php

namespace models\commands;

class OpacityMixerCommandModel extends InputCommandModel
{
	public function casparCommandIn($userData) {
		$result = sprintf(
			'MIXER %d-%d OPACITY %.2f 12',
			$this->channel, $this->layer,
			$this->opacity
		);
		return $result;
	}
	
	public function casparCommandOut() {
		$result = sprintf('MIXER %d-%d OPACITY 1 12', $this->channel, $this->layer);
		return $result;
	}
	
	
	public $opacity;
	
}

?>
