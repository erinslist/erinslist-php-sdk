<?php

namespace Erinslist;

class Reporter {
    public function __construct($name, $email) {
        $this->name = $name;
        $this->email = $email;
    }
}