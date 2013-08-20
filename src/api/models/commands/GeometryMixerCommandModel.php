<?php

namespace models\commands;

class GeometryMixerCommandModel extends InputCommandModel
{
	
	public function casparCommandIn($userData) {
		// TODO These need to come from somewhere else. CP 2013-08
		$channelWidth = 1280;
		$channelHeight = 720;
		
		$x = $this->x / $channelWidth;
		$y = $this->y / $channelHeight;
		$w = $this->w / $channelWidth;
		$h = $this->h / $channelHeight;
		
		$result = sprintf(
			'MIXER %d-%d FILL %.6f %.6f %.6f %.6f 12', 
			$this->channel, $this->layer, 
			$x, $y, $w, $h
		);
		return $result;
	}
	
	public function casparCommandOut() {
		$result = sprintf('MIXER %d-%d FILL 0 0 1 1 12', $this->channel, $this->layer);
		return $result;
	}
	
	public $x;
	public $y;
	public $w;
	public $h;	
	
}

?>
