<?php

namespace Erinslist;

class Position {
	public function __construct($lat, $lng) {
		$this->lat = $lat;
		$this->lng = $lng;
	}

	public function to_array() {
		return [$this->lat, $this->lng];
	}
}