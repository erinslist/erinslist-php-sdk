<?php

namespace Erinslist;
use \Common\Util;

class Incident {
    public function __construct($data) {
    	$this->id = Util::get('id', $data);
    	$this->address = Util::get('address', $data);
    	$this->position = new Position(Util::get('lat', $data), Util::get('lng', $data));
    	$this->notes = Util::get('notes', $data);
    	$this->reported_by = Util::get('reportered_by', $data);
    	$this->reported_at = Util::get('reported_at', $data);
    }
}