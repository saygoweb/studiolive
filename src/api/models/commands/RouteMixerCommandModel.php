<?php

namespace models\commands;

class RouteMixerCommandModel extends InputCommandModel
{
	
	public function casparCommandIn() {
		if (!empty($this->srcLayer)) {
			$result = sprintf('ROUTE %d-%d route://%d-%d', $this->channel, $this->layer, $this->srcChannel, $this->srcLayer);
		} else {
			$result = sprintf('ROUTE %d-%d route://%d', $this->channel, $this->layer, $this->srcChannel);
		}
		return $result;
	}
	
	public function casparCommandOut() {
		$result = sprintf('STOP %d-%d', $this->channel, $this->layer);
		return $result;
	}

	/**
	 * The source channel
	 * @var int
	 */
	public $srcChannel;
	
	/**
	 * The source layer
	 * @var int
	 */
	public $srcLayer;
	
}

?>
